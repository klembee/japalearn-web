<?php


namespace App\Http\Controllers;


use App\Helpers\SRSHelper;
use App\Helpers\SubscriptionHelper;
use App\Models\KanjiLearningPath;
use App\Models\KanjiLearningPathItemStats;
use App\Models\WordType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KanjiDashboardController extends Controller
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

        $vocabUser = $user->info->kanjiLearningPathStats;
        $allVocabItems = KanjiLearningPath::query()
            ->where('level', $user->info->kanji_level)
            ->whereNotIn('id', $vocabUser->pluck('learning_path_item_id'))
            ->orderBy('level', 'asc')
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
        $nextReviewIn = $user->info->next_kanji_review_in;

        return view('app.kanji_vocabulary.index', compact(
            'user',
            'userLearnedKanas',
            'itemsToLearn',
            'itemsToReview',
            'vocabUser',
            'nextWeekVocabReview',
            'nextReviewIn'
            ));
    }

}
