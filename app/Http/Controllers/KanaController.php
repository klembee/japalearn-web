<?php


namespace App\Http\Controllers;


use App\Helpers\SRSHelper;
use App\Models\Kana;
use Illuminate\Http\Request;

class KanaController extends Controller
{
    public function index(Request $request){
        $user = $request->user();

        $allKanas = Kana::all();
        $kanaUser = $user->info->kanaLearningPathStats;
        $allKanasNotDone = Kana::query()->whereNotIn('id', $kanaUser->pluck('kana_id'))->limit(10)->get()->toArray();

        $helper = new SRSHelper($allKanasNotDone, $kanaUser->toArray(), 3, 10);
        $itemsToLearn = $helper->toLearnAvailable();
        $itemsToReview = $helper->reviewsAvailable();

        $nextWeekKanaReview = $user->info->getNextWeekKanaReviews();

        return view('app.kanas.index', compact(
            'itemsToLearn',
            'itemsToReview',
            'allKanas',
            'kanaUser',
            'nextWeekKanaReview'
        ));
    }
}
