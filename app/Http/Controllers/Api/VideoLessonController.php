<?php


namespace App\Http\Controllers\Api;


use App\Helpers\AppointmentHelper;
use App\Http\Controllers\Controller;
use App\Mail\AppointmentConfirmed;
use App\Models\Appointment;
use App\Models\Role;
use App\Models\TeacherAvailability;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Laravel\Cashier\Payment;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class VideoLessonController extends Controller
{

    /**
     * Allow a user to view the availabilities of a
     * specified teacher
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function fetchAvailabilities(Request $request){

        if($request->has('teacher_id')) {
            $teacher = User::query()->where('id', $request->input('teacher_id'))->firstOrFail();
        }else{
            // If the teacher_id is not provided, use the logged in user instead
            $teacher = $request->user();
        }

        if(!$teacher->isTeacher()){
            return response()->json([
                'success' => false,
                'message' => "The provided user is not a teacher."
            ]);
        }

        try {
            $this->authorize('canFetchAvailabilitiesOf', [TeacherAvailability::class, $teacher]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => "You are not allowed to view the availabilities of this teacher."
            ]);
        }

        $availabilities = TeacherAvailability::query()->where('teacher_id', $teacher->id)->get();

        return response()->json([
            'count' => $availabilities->count(),
            'data' => $availabilities->groupBy('week_day'),
        ]);
    }

    public function fetchAvailabilitiesForDate(Request $request){
        $this->validate($request, [
            'date' => "required|date",
            'teacher_id' => "required"
        ]);

        $teacher = User::query()
            ->where('role_id', Role::teacher()->id)
            ->where('id', $request->input('teacher_id'))->firstOrFail();

        //todo: Check that the user have access to this teacher's availabilities

        $date = Carbon::createFromFormat("Y-m-d", $request->input('date'));

        if($date->isBefore(Carbon::now()->addWeek()->startOfDay())){
            return response()->json([
                'success' => false,
                'message' => "You can only schedule a lesson one week in advance !"
            ]);
        }
        $scheduleDayOfWeek = strtolower($date->dayName);

        $times = TeacherAvailability::query()
            ->where('teacher_id', $teacher->id)
            ->where('week_day', $scheduleDayOfWeek)->get()->pluck('hour');

        //todo: Remove the hours that already have a scheduled lesson

        return response()->json([
            'success' => true,
            'times' => $times
        ]);
    }

    /**
     * Allows a teacher to edit his/her availabilities for
     * video lessons
     * @param Request $request
     * @return string
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updateAvailability(Request $request){
        $this->authorize('update', TeacherAvailability::class);

        try {
            $this->validate($request, [
                'availabilities' => 'required'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => true
            ]);
        }

        $user = $request->user();
        $availabilities = $request->input('availabilities');

        // Toggle the availability in the database
        foreach($availabilities as $weekday => $times){
            foreach($times as $time){
                if(!$this->alreadyHaveThisAvailability($user, $weekday, $time)){
                    // Add the new availability to the teacher
                    $availability = new TeacherAvailability();
                    $availability->teacher_id = $user->id;
                    $availability->week_day = $weekday;
                    $availability->hour = $time;
                    $availability->save();

                }else{
                    // Remove this availability from teacher
                    try{
                        TeacherAvailability::query()
                            ->where('teacher_id', $user->id)
                            ->where('week_day', $weekday)
                            ->where('hour', $time)->first()->delete();
                    }catch (\Exception $e){
                        return response()->json([
                            'success' => false
                        ]);
                    }

                }
            }
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function confirmLesson(Request $request, Appointment $lesson){
        return AppointmentHelper::confirm($lesson);
    }

    /**
     * Schedule a lesson with a teacher.
     * Apply a payment to the user
     * @param Request $request
     * @return string
     * @throws ValidationException
     */
    public function scheduleWithTeacher(Request $request){
        $this->validate($request, [
            'teacher_id' => 'required',
            'date' => 'required|date|date_format:Y-m-d',
            'time' => 'required|date_format:H:i',
            'duration' => 'required',
            'total' => 'required',
            'card' => 'required'
        ]);

        $user = $request->user();

        if(!$user->stripe_id){
            $user->createAsStripeCustomer();
        }

        $total = round($request->input('total') * 100);
        $cardId = $request->input('card');
        $date = $request->input('date');
        $time = $request->input('time');
        $duration = $request->input('duration');

        $teacher = User::query()->where('role_id', Role::teacher()->id)
            ->where('id', $request->input('teacher_id'))->first();

        if(!$teacher){
            return response()->json([
                'success' => false,
                'message' => 'Failed to find specified teacher.'
            ]);
        }

        // Check if the teacher have setup his/her stripe account
        if(!$teacher->info->stripe_account_id){
            $request->session()->flash('error', 'This teacher cannot accept appointments.');
            return redirect()->back();
        }

        $teacher_account_id = $teacher->info->stripe_account_id;

        // Make the payment on the credit card
        try {
            $payment = $user->charge($total, $cardId, [
                'receipt_email' => $user->email,
                'capture_method' => 'manual',
                'application_fee_amount' => round(0.10 * $total), //todo: Check with comptable taxes
                'on_behalf_of' => $teacher_account_id
            ]);

            // Add the scheduled meeting in database and send email to both users
            $appointment = new Appointment([
                'date' => $date . " " . $time,
                'duration_minute' => $duration,
                'cost_total' => $total,
                'payment_stripe_id' => $payment->id,
            ]);
            $appointment->student_info_id = $user->info->id;
            $appointment->teacher_info_id = $teacher->info->id;

            $appointment->save();

        }catch(\Exception $e){
            error_log($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => "Failed to apply payment on credit card."
            ]);
        }

        return response()->json([
            'success' => true,
            'redirect_url' => route('dashboard')
        ]);
    }

    /**
     * Check if the provided teacher already have set an availability
     * at provided weekday and hour
     * @param $teacher
     * @param $weekday
     * @param $hour
     * @return bool
     */
    private function alreadyHaveThisAvailability($teacher, $weekday, $hour){
        return TeacherAvailability::query()
            ->where('teacher_id', $teacher->id)
            ->where('week_day', $weekday)
            ->where('hour', $hour)->count() > 0;
    }
}
