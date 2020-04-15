<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Api class that controls the modules that are showing on
 * the dashboards.
 *
 * Class DashboardController
 * @package App\Http\Controllers\Api
 */
class DashboardController extends Controller
{

    /**
     * Get data about the vocab size of the logged in user
     * every day for the past month. This is used to create a graph
     *
     * @param Request $request
     * @return array
     */
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
