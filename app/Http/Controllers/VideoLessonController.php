<?php


namespace App\Http\Controllers;


use App\Models\Role;
use App\Models\User;
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

        return view('app.video_lessons.index');
    }

    /**
     * Displays a form allowing a student to schedule a
     * view lesson from a certain teacher at a certain time
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function scheduleLesson(Request $request){
        if(!$request->user()->isStudent()){
            return response()->make("Error", 403);
        }

        $this->validate($request, [
            'teacher' => 'required'
        ]);


        $teacher = User::query()->with('info')
            ->where('role_id', Role::teacher()->id)
            ->where('id', $request->query('teacher'))->firstOrFail();

        error_log(print_r($teacher->info->information, true));

        //todo: Validate that the user can schedule lesson with this teacher.

        return view('app.video_lessons.schedule', compact('teacher'));
    }

    /**
     * Save the schedule form data to the database
     * @param Request $request
     */
    public function scheduleLessonSave(Request $request){

    }
}
