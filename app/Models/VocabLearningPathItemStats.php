<?php


namespace App\Models;


use App\Helpers\SRSHelper;
use App\Interfaces\Learnable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class VocabLearningPathItemStats extends Model implements Learnable
{
    protected $table = "vocab_learning_path_item_student";
    protected $appends = [
        'level',
        'last_review_date',
        'human_level',
        'object_id',
        'answers',
        'next_review',
//        'on_reading',
//        'kun_reading'
        'level_interval'
    ];

    public static $LEVELS_INTERVAL = [0, 4, 8, 24, 72, 168, 336, 720, 2880]; # In hours

    protected $dates = [
        'last_study_date'];

    public function student(){
        return $this->belongsTo(User::class);
    }

    public function vocabLearningPathItem(){
        return $this->belongsTo(VocabLearningPath::class, 'learning_path_item_id');
    }

    public function getNextReviewAttribute(){
        return $this->last_study_date->addHours(VocabLearningPathItemStats::$LEVELS_INTERVAL[$this->nb_right]);
    }

    public function getLastReviewDateAttribute()
    {
        return $this->last_study_date;
    }

    public function getLevelAttribute()
    {
        return $this->nb_right;
    }


    public function getHumanLevelAttribute()
    {
        if ($this->level < 0) return 'Inactive';
        if ($this->level <= 3) return 'Apprentice';
        if ($this->level <= 5) return 'Guru';
        if ($this->level <= 6) return 'Master';
        if ($this->level <= 7) return 'Enlightened';
        return 'Burned';
    }

    public function getAnswersAttribute()
    {
//        if($this->vocabLearningPathItem->word_type_id == WordType::radical()->id) {
//            return array_map(function($meaning){
//                return strtolower($meaning['meaning']);
//            }, $this->vocabLearningPathItem->meanings->toArray());
//
//        }else {
//            return array_map(function($meaning){
//                return strtolower($meaning['reading']);
//            }, $this->vocabLearningPathItem->readings->toArray());
//        }
        return $this->vocabLearningPathItem->answers;
    }

//    public function getOnReadingAttribute(){
//
//        error_log(print_r($this->vocabLearningPathItem()->with('onReadings')->get(), true));
//
//        return $this->vocabLearningPathItem()->with('onReadings')->onReadings->get();
//    }
//
//    public function getKunReadingAttribute(){
//        return $this->vocabLearningPathItem()->with('kunReadings')->kunReadings->get();
//    }

    public function getObjectIdAttribute()
    {
        return "vocab_learning_path_item";
    }

    public function getLevelIntervalAttribute()
    {
        return VocabLearningPathItemStats::$LEVELS_INTERVAL;
    }
}
