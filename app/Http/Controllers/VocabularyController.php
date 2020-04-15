<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

/**
 * Class that controls everything relating vocabulary
 *
 * Class VocabularyController
 * @package App\Http\Controllers
 */
class VocabularyController extends Controller
{

    /**
     * Only the students can have vocabulary items associated
     * with them.
     *
     * VocabularyController constructor.
     */
    public function __construct()
    {
        $this->middleware('isRole:student');
    }

    /**
     * Displays the list of vocabulary of the logged in student
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $user = $request->user();

        $vocabularies = $user->vocabulary()->paginate(5);

        return view('app.vocabulary.index', compact('vocabularies'));
    }
}
