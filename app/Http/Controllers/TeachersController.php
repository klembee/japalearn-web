<?php


namespace App\Http\Controllers;



use Illuminate\Http\Request;

class TeachersController extends Controller
{
    public function __construct()
    {
        $this->middleware('isRole:student');
    }

    /**
     * Displays a list of teachers for the current user
     */
    public function index(Request $request){
        $teachers = $request->user()->teachers;

        return view('app.teachers.index', compact('teachers'));
    }
}
