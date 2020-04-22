<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\TeacherAvailability;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
