<?php


namespace App\Http\Controllers;


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
     * Only teachers have access to this section
     * VideoLessonController constructor.
     */
    public function __construct()
    {
        $this->middleware('isRole:teacher');
    }

    /**
     * Show a dashboard with video lessons stats and settings
     * @param Request $request
     * @return string
     */
    public function index(Request $request){
        return view('app.video_lessons.index');
    }
}
