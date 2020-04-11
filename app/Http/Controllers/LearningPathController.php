<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

class LearningPathController extends Controller
{
    public function __construct()
    {
        //Check user is admin
        $this->middleware('isRole:admin');
    }

    public function index(Request $request){
        return view('app.learningpath.index');
    }

    public function newLevel(Request $request){
        return redirect()->route("learningpath.vocab.index");
    }
}
