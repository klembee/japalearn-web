<?php


namespace App\Http\Controllers;


use App\Helpers\SRSHelper;
use App\Models\VocabLearningPath;
use App\Models\VocabLearningPathItemStats;
use App\Models\WordType;
use Carbon\Carbon;
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

        $userLearnedKanas = $user->info->information->finishedKanas();

        $vocabUser = $user->info->information->vocabLearningPathStats;
        $allVocabItems = VocabLearningPath::query()
            ->where('word_type_id', WordType::kanji()->id)
            ->where('level', $user->info->information->kanji_level)
            ->whereNotIn('id', $vocabUser->pluck('learning_path_item_id'))
            ->orderBy('level', 'asc')
            ->orderBy('word_type_id', 'asc')
            ->orderBy('word')
            ->limit(30)->get()
            ->toArray();

        $helper = new SRSHelper($allVocabItems, $vocabUser->toArray());
        $itemsToLearn = $helper->toLearnAvailable();
        $itemsToReview = $helper->reviewsAvailable();

        $nextWeekVocabReview = $user->info->information->getNextWeekVocabReviews();

        return view('app.kanji_vocabulary.index', compact(
            'user',
            'userLearnedKanas',
            'itemsToLearn',
            'itemsToReview',
            'vocabUser',
            'nextWeekVocabReview'));
    }

}
