<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

/**
 * This class is the controller for all the routes relating the dictionary
 * Class DictionaryController
 * @package App\Http\Controllers
 */
class DictionaryController extends Controller
{

    /**
     * Allows the user to query the dictionary and save words in his/her vocabulary
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $vocabularies = $request->user()->vocabulary;
        $isStudent = $request->user()->isStudent();

        return view('app.dictionary.index', compact('vocabularies', 'isStudent'));
    }
}
