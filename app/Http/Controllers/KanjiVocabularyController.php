<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

class KanjiVocabularyController extends Controller
{
    /**
     * Displays to the student a dashboard showing the lessons
     * and reviews available and stats about learning
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $user = $request->user();

        return view('app.kanji_vocabulary.index', compact('user'));
    }

}
