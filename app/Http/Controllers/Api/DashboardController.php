<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function vocabSizePerDayThisMonth(Request $request){
        $user = $request->user();
        $now = Carbon::now();
        $start = $now->copy()->subMonth();
        $nbDays = $now->copy()->diffInDays($start);

        $vocabSizePerDay = [];

        $date = $start->copy()->endOfDay();
        for($i = 0; $i <= $nbDays ; $i++){
            $dateFormated = $date->format("Y-m-d");
            if(!array_key_exists($dateFormated, $vocabSizePerDay)){
                $vocabSizePerDay[$dateFormated] = 0;
            }

            $vocabSizePerDay[$dateFormated] = $user->userInfo->vocabLearningPathStats->where('created_at', '<=', $date)->count();
            $date->addDay();
        }

        return $vocabSizePerDay;
    }

}
