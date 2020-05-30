<?php


namespace App\Http\Controllers;


use App\Helpers\AppointmentHelper;
use App\Models\Appointment;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Controller for everything relating the video lessons that teachers can
 * make
 * Class VideoLessonController
 * @package App\Http\Controllers
 */
class VideoLessonController extends Controller
{
    /**
     * Show a dashboard with video lessons stats and settings.
     * Only teachers have access to this section.
     * @param Request $request
     * @return string
     */
    public function index(Request $request){
        //todo: Verify that user is teacher with $this->authorize
        if(!$request->user()->isTeacher()){
            return response()->make("Error", 403);
        }

        $user = $request->user();
        $unconfirmedLessons = $user->info->appointments()->with(['studentInfo', 'studentInfo.user'])->where('confirmed', false)->get();
        $commingLessons = $user->info->appointments()
            ->with(['studentInfo', 'studentInfo.user'])
            ->where('confirmed', true)
            ->where('date', '>=', Carbon::now())->get();

        error_log($commingLessons->count());

        return view('app.video_lessons.index', compact('unconfirmedLessons', 'commingLessons'));
    }

    /**
     * Displays a form allowing a student to schedule a
     * view lesson from a certain teacher at a certain time
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function scheduleLesson(Request $request, User $teacher){
        if(!$request->user()->isStudent()){
            return response()->make("Error", 403);
        }

        // Check if the teacher have setup his/her stripe account
        if(!$teacher->info->stripe_account_id){
            $request->session()->flash('error', 'This teacher cannot accept appointments.');
            return redirect()->back();
        }

        //todo: Validate that the user can schedule lesson with this teacher.

        $stripeIntent = $request->user()->createSetupIntent()->client_secret;
        $creditCardsStripe = $request->user()->paymentMethods()->toArray();
        $creditCards = [];
        foreach($creditCardsStripe as $creditCard){
            $creditCards[] = [
                'id' => $creditCard->id,
                'last4' => $creditCard->card->last4,
                'exp_month' => $creditCard->card->exp_month,
                'exp_year' => $creditCard->card->exp_year
            ];

        }

        return view('app.video_lessons.schedule', compact('teacher', 'stripeIntent', 'creditCards'));
    }

    public function updateInformation(Request $request){
        $this->validate($request, [
            'pricing_hour' => "required",
        ]);

        $teacher = $request->user();

        $info = $teacher->info;
        $info->video_lesson_price_hour = $request->input('pricing_hour') * 100;

        if($request->has('description')){
            $info->description = $request->input('description');
        }

        $info->offer_free_trial = $request->has('offer_free_trial');

        $info->save();

        return redirect()->back();
    }

    /**
     * Save the schedule form data to the database
     * @param Request $request
     */
    public function scheduleLessonSave(Request $request){

    }

    public function rateLesson(Request $request, Appointment $appointment){
        $this->authorize('rate', $appointment);

        $teacher = $appointment->teacherInfo->user;

        return view('app.video_lessons.rateLesson', compact('appointment', 'teacher'));
    }

    public function teacherConfirmAppointment(Request $request, Appointment $appointment){
        $this->authorize('confirm', $appointment);
        AppointmentHelper::confirm($appointment);

        $request->session()->flash('success', 'Appointment confirmed with student');

        return redirect()->route('dashboard');
    }

    public function teacherRefuseAppointment(Request $request, Appointment $appointment){
        $this->authorize('confirm', $appointment);
        AppointmentHelper::refuse($appointment);

        $request->session()->flash('success', 'Appointment refused');

        return redirect()->route('dashboard');
    }
}
