<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

class DictionaryController extends Controller
{
    public function index(Request $request){
        $vocabularies = $request->user()->vocabulary;
        $isStudent = $request->user()->isStudent();

        return view('app.dictionary.index', compact('vocabularies', 'isStudent'));
    }
}
