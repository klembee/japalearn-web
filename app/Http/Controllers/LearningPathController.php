<?php


namespace App\Http\Controllers;


class LearningPathController extends Controller
{
    public function __construct()
    {
        //Check user is admin
        $this->middleware('isRole:admin');
    }

    public function index(){
        return view('app.learningpath.index');
    }
}
