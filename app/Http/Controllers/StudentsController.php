<?php


namespace App\Http\Controllers;



use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('isRole:teacher');
    }

    public function index(Request $request){
        $students = $request->user()->students;

        return view('app.students.index', compact('students'));
    }
}
