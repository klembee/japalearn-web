<?php


namespace App\Http\Controllers;



use Illuminate\Http\Request;


/**
 * This class controls everything relating the students
 *
 * Class StudentsController
 * @package App\Http\Controllers
 */
class StudentsController extends Controller
{

    /**
     * Only the teachers have access to these views
     * StudentsController constructor.
     */
    public function __construct()
    {
        $this->middleware('isRole:teacher');
    }

    /**
     * Allow a teacher to views all of his/her students
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $students = $request->user()->students;

        return view('app.students.index', compact('students'));
    }
}
