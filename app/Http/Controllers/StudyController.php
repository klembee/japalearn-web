<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

class StudyController extends Controller
{
    public function vocabularyReview(Request $request){
        return view("app.study.vocab_review");
    }
}
