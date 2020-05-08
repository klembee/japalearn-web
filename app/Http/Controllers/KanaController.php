<?php


namespace App\Http\Controllers;


use App\Helpers\SRSHelper;
use App\Models\Kana;
use Illuminate\Http\Request;

class KanaController extends Controller
{
    public function index(Request $request){
        $user = $request->user();

        $allKanas = Kana::all()->toArray();
        $kanaUser = $user->info->information->kanaLearningPathStats->toArray();
        $helper = new SRSHelper($allKanas, $kanaUser);
        $itemsToLearn = $helper->toLearnAvailable();
        $itemsToReview = $helper->reviewsAvailable();

        return view('app.kanas.index', compact('itemsToLearn', 'itemsToReview', 'allKanas', 'kanaUser'));
    }
}
