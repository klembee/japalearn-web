<?php


namespace App\Http\Controllers;


use App\Helpers\SRSHelper;
use App\Models\Kana;
use App\Models\VocabLearningPath;
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

        $allKanas = Kana::all()->toArray();
        $kanaUser = $user->info->information->kanaLearningPathStats->toArray();

        $helper = new SRSHelper($allKanas, $kanaUser);
        $itemsToLearn = $helper->toLearnAvailable();

        $itemsBeforeReviews = 5;
        if(count($itemsToLearn) == 0){
            // No items to learn, redirect to dashboard
            return redirect()->route('dashboard');
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
    public function review(){

    }
}
