<?php


namespace App\Http\Controllers;


use App\Models\VocabLearningPath;
use App\Models\WordType;
use Illuminate\Http\Request;

/**
 * This class controls all the routes for the learning paths tasks
 * A learning path contains sequential study material that the student
 * should do.
 *
 * Only admins have access to this section.
 *
 * Class LearningPathController
 * @package App\Http\Controllers
 */
class LearningPathController extends Controller
{

    /**
     * Checks that the user accessing this section is an admin
     * LearningPathController constructor.
     */
    public function __construct()
    {
        //Check user is admin
        $this->middleware('isRole:admin');
    }

    /**
     * Shows the list of learning paths that exist and group them by level.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){

        $itemsByLevel = VocabLearningPath::query()->with('vocabulary')->get()->groupBy('level');

        return view('app.learningpath.index', compact('itemsByLevel'));
    }


    /**
     * View a specific learning path of a certain level.
     * It gives to the view the learning path item grouped by the word type
     * (radical, kanji, vocabulary)
     *
     * @param Request $request
     * @param int $level
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewLevel(Request $request, int $level){

        $radicals = VocabLearningPath::query()->where('word_type_id', WordType::radical()->id)->with('meanings', 'readings')->get();

        $kanjis = VocabLearningPath::query()->where('word_type_id', WordType::kanji()->id)->with('meanings', 'readings')->get();

        $vocabulary = VocabLearningPath::query()->where('word_type_id', WordType::vocabulary()->id)->with('meanings', 'readings')->get();

        return view('app.learningpath.edit_level', compact('radicals', 'kanjis', 'vocabulary'));
    }
}
