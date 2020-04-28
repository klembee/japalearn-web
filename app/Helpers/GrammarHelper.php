<?php


namespace App\Helpers;


use App\Models\GrammarLearningPathItem;
use App\Models\StudentInfo;
use Illuminate\Support\Facades\Auth;

class GrammarHelper
{

    /**
     * Get the next grammar item that the student
     * should learn
     * @return mixed
     */
    public static function getNextItem(){
        $itemsNotDone = GrammarLearningPathItem::notDone()->get();

        return $itemsNotDone[0];
    }
}
