<?php


namespace App\Http\Controllers;


use App\Helpers\SRSHelper;
use App\Models\VocabLearningPath;
use App\Models\VocabLearningPathItemStats;
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

        $allVocabItems = VocabLearningPath::all()->toArray();
        $vocabUser = $user->info->information->vocabLearningPathStats->toArray();

        $helper = new SRSHelper($allVocabItems, $vocabUser);
        $itemsToLearn = $helper->toLearnAvailable();
        $itemsToReview = $helper->reviewsAvailable();

        error_log(print_r($itemsToLearn, true));

        return view('app.kanji_vocabulary.index', compact('user', 'itemsToLearn', 'itemsToReview', 'vocabUser'));
    }

}
