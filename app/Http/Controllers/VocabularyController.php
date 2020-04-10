<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    /**
     * Displays the list of vocabulary of the current user
     * @param Request $request
     */
    public function index(Request $request){
        $user = $request->user();
        //todo: check user is student

        $vocabularies = $user->vocabulary()->paginate(5);

        return view('app.vocabulary.index', compact('vocabularies'));
    }
}
