<?php


namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StudentInfo extends Model
{
    protected $table = "student_info";
//    protected $appends = ['number_reviews', 'number_lessons'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function vocabLearningPathStats(){
        return $this->hasMany(VocabLearningPathItemStats::class, 'student_info_id');
    }

    public function kanaLearningPathStats(){
        return $this->hasMany(KanaLearningStats::class, 'student_info_id');
    }

    public function grammarItemsDone(){
        return $this->belongsToMany(GrammarLearningPathItem::class, 'grammar_lesson_student',  'grammar_item_id','student_info_id');
    }

    public function activity(){
        return $this->hasMany(StudentActivity::class);
    }

    /**
     * Get the date and time that the user will have
     * reviews for the next week. It is used to the review forecast component
     * @return mixed
     */
    public function getNextWeekVocabReviews(){
        // Get the vocab review for the week
        $nextWeek = Carbon::now()->addWeek();
        $vocabsNextWeek = $this->vocabLearningPathStats->filter(function($obj, $key) use($nextWeek){
            return $obj->next_review->lte($nextWeek);
        });

        // Sort them by review date
        $vocabsNextWeekTimes = $vocabsNextWeek->map(function($obj, $key){
            return $obj->next_review->addHour()->format("Y-m-d H:00:00");
        });
        return $vocabsNextWeekTimes->countBy()->all();
    }

    public function finishedKanas(){
        $kana_user = $this->kanaLearningPathStats;
        $all_over_lvl_5 = true;

        foreach ($kana_user as $kana){
            if($kana->number_right < 5){
                $all_over_lvl_5 = false;
                break;
            }
        }

        if($kana_user->count() == Kana::all()->count() && $all_over_lvl_5){
            return true;
        }
        return false;
    }
}
