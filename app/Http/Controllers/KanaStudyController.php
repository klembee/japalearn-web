<?php


namespace App\Http\Controllers;


use App\Helpers\SRSHelper;
use App\Models\Kana;
use App\Models\KanjiLearningPath;
use Illuminate\Http\Request;

/**
 * Controller that allows the user to learn and review kanas
 * Class KanaStudyController
 * @package App\Http\Controllers
 */
class KanaStudyController extends Controller
{
    /**
     * Allow the user to learn new kanas
     */
    public function lesson(Request $request){
        $user = $request->user();

        $kanaUser = $user->info->kanaLearningPathStats;
        $allKanas = Kana::query()->whereNotIn('id', $kanaUser->pluck('kana_id'))->limit(10)->get()->toArray();

        $helper = new SRSHelper($allKanas, $kanaUser->toArray(), 3, 10);
        $itemsToLearn = $helper->toLearnAvailable();

        $itemsBeforeReviews = 5;
        if(count($itemsToLearn) == 0){
            // No items to learn, redirect to dashboard
            return redirect()->route('kanas.index');
        }

        $items_chunk = array_chunk($itemsToLearn, $itemsBeforeReviews, false);

        return view("app.study.kana_lesson", [
            'items' => json_encode($items_chunk),
            'mode' => 'learn'
        ]);
    }

    /**
     * Allow the user to review already learned kanas
     */
    public function review(Request $request){
        $user = $request->user();
        $allKanas = Kana::all()->toArray();
        $kanaUser = $user->info->kanaLearningPathStats->toArray();

        $helper = new SRSHelper($allKanas, $kanaUser, 3, 10, 5);
        $reviews = $helper->reviewsAvailable();


        return view("app.study.kana_review", [
           'reviews' => json_encode($reviews),
        ]);
    }
}
