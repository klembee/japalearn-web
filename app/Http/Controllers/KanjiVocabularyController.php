<?php


namespace App\Http\Controllers;


use App\Helpers\SRSHelper;
use App\Helpers\SubscriptionHelper;
use App\Models\VocabLearningPath;
use App\Models\VocabLearningPathItemStats;
use App\Models\WordType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KanjiVocabularyController extends Controller
{

    private function checkSubscribed(Request $request){
        if($request->user()->info->kanji_level >= 4){
            if(!SubscriptionHelper::isSubscribed($request)){
                return redirect()->route('account.subscription.index');
            }
        }

        return true;
    }

    /**
     * Displays to the student a dashboard showing the lessons
     * and reviews available and stats about learning
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $user = $request->user();

        $userLearnedKanas = $user->info->finishedKanas();

        $vocabUser = $user->info->vocabLearningPathStats;
        $allVocabItems = VocabLearningPath::query()
            ->where('word_type_id', WordType::kanji()->id)
            ->where('level', $user->info->kanji_level)
            ->whereNotIn('id', $vocabUser->pluck('learning_path_item_id'))
            ->orderBy('level', 'asc')
            ->orderBy('word_type_id', 'asc')
            ->orderBy('word');


        $subscribed = $this->checkSubscribed($request);
        if($subscribed !== true){
            $allVocabItems = $allVocabItems->where('level', '<', 4);
        }

        $allVocabItems = $allVocabItems->limit(30)->get()
            ->toArray();

        $helper = new SRSHelper($allVocabItems, $vocabUser->toArray());
        $itemsToLearn = $helper->toLearnAvailable();
        $itemsToReview = $helper->reviewsAvailable();

        $nextWeekVocabReview = $user->info->getNextWeekVocabReviews();

        return view('app.kanji_vocabulary.index', compact(
            'user',
            'userLearnedKanas',
            'itemsToLearn',
            'itemsToReview',
            'vocabUser',
            'nextWeekVocabReview'));
    }

}
