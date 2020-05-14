<?php


namespace App\Helpers;

use App\Interfaces\Learnable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Helper class for the spaced repetition algorithm
 * Class SRSHelper
 * @package App\Helpers
 */
class SRSHelper
{
    private $levels_interval = [4, 8, 24, 72, 168, 336, 720, 2880]; # In hours

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
                // This is to get the object and not the object-student association
                $toReview[] = array_values(array_filter($this->allObjects, function($object) use ($item){
                    return $object['id'] == $item['object_id'];
                }))[0];
            }
        }

        $answers = [];
        foreach($toReview as $item){
            $answers[] = $item['answers'];
        }

        return $toReview;
    }

    /**
     * Verify if the item need to be reviewed
     * @param Learnable $item
     * @return bool
     */
    private function itemNeedReview($item){
        return Carbon::now()->diffInHours($item['last_review_date']) > $this->levels_interval[$item['level'] - 1];
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

    /**
     * Get the objects that the users have not learned yet
     * @return array
     */
    private function unlearnedItems(){
        // Get the indices of the objects the user learned
        $itemsLearnedIndices = array_column($this->objectUser, 'object_id');

        return array_filter($this->allObjects, function($item) use ($itemsLearnedIndices){
            return !in_array($item['id'], $itemsLearnedIndices);
        });
    }
}
