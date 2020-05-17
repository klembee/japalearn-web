<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class StudentActivity extends Model
{
    protected $table = "student_activity";

    protected $fillable = [
        'nb_items'
    ];

    protected $appends = [
        'display_text'
    ];

    public function studentInfo(){
        return $this->belongsTo(StudentInfo::class, 'student_info_id');
    }

    public function activity(){
        return $this->belongsTo(ActivityType::class, 'activity_type_id');
    }

    public function getDisplayTextAttribute(){
        switch ($this->activity->id){
            case ActivityType::kanjiReviewed()->id:
                return "# kanjis reviewed";
                break;
            case ActivityType::kanjiLearned()->id:
                return "# kanjis learned";
                break;
            case ActivityType::kanaReviewed()->id:
                return "# kanas reviewed";
                break;
            case ActivityType::kanaLearned()->id:
                return "# kana learned";
                break;
            case ActivityType::grammarLearned()->id:
                return "# grammar item learned";
                break;
            case ActivityType::storyRead()->id:
                return "# story learned";
                break;
        }

        return "#";
    }
}
