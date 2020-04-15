<?php


namespace App\Http\Controllers;



use Illuminate\Http\Request;

/**
 * Class that controls every relating the teachers
 *
 * Class TeachersController
 * @package App\Http\Controllers
 */
class TeachersController extends Controller
{

    /**
     * Only the students can access these views
     *
     * TeachersController constructor.
     */
    public function __construct()
    {
        $this->middleware('isRole:student');
    }

    /**
     * Displays a list of teachers that the current student
     * connected with
     */
    public function index(Request $request){
        $teachers = $request->user()->teachers;

        return view('app.teachers.index', compact('teachers'));
    }
}
