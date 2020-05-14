<?php


namespace App\Http\Controllers;


use App\Helpers\SRSHelper;
use App\Models\Kana;
use Illuminate\Http\Request;

class KanaController extends Controller
{
    public function index(Request $request){
        $user = $request->user();

        error_log(print_r(Kana::hiraganas()->get()->pluck('kana')->toArray(), true));

        $allKanas = Kana::all()->toArray();
        $kanaUser = $user->info->information->kanaLearningPathStats->toArray();
        $helper = new SRSHelper($allKanas, $kanaUser, 3, 10);
        $itemsToLearn = $helper->toLearnAvailable();
        $itemsToReview = $helper->reviewsAvailable();

        return view('app.kanas.index', compact('itemsToLearn', 'itemsToReview', 'allKanas', 'kanaUser'));
    }
}
