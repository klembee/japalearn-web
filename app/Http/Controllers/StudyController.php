<?php


namespace App\Http\Controllers;


use App\Helpers\SRSHelper;
use App\Models\VocabLearningPath;
use App\Models\WordType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;


/**
 * Class that controls all the study related stuff
 *
 * Class StudyController
 * @package App\Http\Controllers
 */
class StudyController extends Controller
{

    /**
     * Get the vocabulary (radical, kanji, vocab) that the logged in
     * user can learn now.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function vocabularyLesson(Request $request){
        $user = $request->user();

        $allVocabItems = VocabLearningPath::all()->toArray();
        $vocabUser = $user->info->information->vocabLearningPathStats->toArray();

        $helper = new SRSHelper($allVocabItems, $vocabUser);
        $itemsToLearn = $helper->toLearnAvailable();

        $itemsBeforeReviews = 5;
        if(count($itemsToLearn) == 0){
            // No items to learn, redirect to dashboard
            return redirect()->route('dashboard');
        }

        $items_chunk = array_chunk($itemsToLearn, $itemsBeforeReviews, false);

        return view("app.study.vocab_lesson", [
            'items' => json_encode($items_chunk),
        ]);
    }

    /**
     * Get the items (radical, kanjis, vocab) that the logged in user
     * can review. After each review, the user have to wait a certain time
     * before reviewing again. This is the principle of spaced repetition
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function vocabularyReview(Request $request){
        $user = $request->user();

        $vocabs = $user->info->information->getVocabReviewItems();

        $writingReviews = $vocabs['review']['writing'];
        $meaningReviews = $vocabs['review']['meaning'];

        $reviews = [];

        foreach($writingReviews as $review){
            array_push($reviews, [
                'question' => $review['vocab_learning_path_item']['word'],
                'answers' => array_map(function($item){
                        return strtolower($item['reading']);
                    }, $review['vocab_learning_path_item']['readings']),
                'type' => 'reading'
            ]);
        }

        foreach($meaningReviews as $review){
            array_push($reviews, [
                'question' => $review['vocab_learning_path_item']['word'],
                'answers' => array_map(function($item){
                    return strtolower($item['meaning']);
                }, $review['vocab_learning_path_item']['meanings']),
                'type' => 'meaning'
            ]);
        }

        return view('app.study.vocab_review', [
            'reviews' => json_encode($reviews)
        ]);
    }
}
