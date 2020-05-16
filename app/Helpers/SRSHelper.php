<?php


namespace App\Helpers;

use App\Interfaces\Learnable;
use App\Models\Kana;
use App\Models\KanaLearningStats;
use App\Models\VocabLearningPathItemStats;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Helper class for the spaced repetition algorithm
 * Class SRSHelper
 * @package App\Helpers
 */
class SRSHelper
{
    public static $LEVELS_INTERVAL = [0, 4, 8, 24, 72, 168, 336, 720, 2880]; # In hours

    /**
     * @var array
     */
    private $allObjects;

    /**
     * @var array
     */
    private $objectUser;

    private $levelBeforeNewItems;
    private $numberItemsAtATime;

    public function  __construct($allObjects, $objectUser, $levelBeforeNewItems = 4, $numberItemsAtATime = 30)
    {
        $this->allObjects = $allObjects;
        $this->objectUser = $objectUser;
        $this->levelBeforeNewItems = $levelBeforeNewItems;
        $this->numberItemsAtATime = $numberItemsAtATime;
    }


    /**
     * Get the items that are ready to be reviewed
     * @return array
     */
    public function reviewsAvailable(){
        $toReview = [];

        foreach($this->objectUser as $item){
            if($this->itemNeedReview($item)){
                $toReview[] = $item[$item['object_id']];

            }
        }

        return $toReview;
    }

    /**
     * Verify if the item need to be reviewed
     * @param Learnable $item
     * @return bool
     */
    private function itemNeedReview($item){
        return Carbon::now()->gte($item['next_review']);
    }

    /**
     * Get the items that are ready to be learned
     * @return array
     */
    public function toLearnAvailable(){
        if(count($this->objectUser) == 0){
            return array_splice($this->allObjects, 0, $this->numberItemsAtATime);
        }

        $nbItemsAvailable = $this->numberItemsAtATime - count(array_filter($this->objectUser, function($item){
            return $item['level'] - 1 < $this->levelBeforeNewItems;
        }));

//        $unlearnedItems = $this->unlearnedItems();

        return array_splice($this->allObjects, 0, $nbItemsAvailable);
    }
}
