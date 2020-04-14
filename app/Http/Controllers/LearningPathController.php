<?php


namespace App\Http\Controllers;


use App\Models\VocabLearningPath;
use App\Models\WordType;
use Illuminate\Http\Request;

class LearningPathController extends Controller
{
    public function __construct()
    {
        //Check user is admin
        $this->middleware('isRole:admin');
    }

    public function index(Request $request){

        $itemsByLevel = VocabLearningPath::query()->with('vocabulary')->get()->groupBy('level');

        return view('app.learningpath.index', compact('itemsByLevel'));
    }

    public function editLevel(Request $request, int $level){

        $radicals = VocabLearningPath::query()->where('word_type_id', WordType::radical()->id)->with('meanings', 'readings')->get();

        $kanjis = VocabLearningPath::query()->where('word_type_id', WordType::kanji()->id)->with('meanings', 'readings')->get();

        $vocabulary = VocabLearningPath::query()->where('word_type_id', WordType::vocabulary()->id)->with('meanings', 'readings')->get();

        return view('app.learningpath.edit_level', compact('radicals', 'kanjis', 'vocabulary'));
    }
}
