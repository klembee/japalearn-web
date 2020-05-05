<?php


namespace App\Models;


use App\Interfaces\Learnable;
use Illuminate\Database\Eloquent\Model;

class KanaLearningStats extends Model implements Learnable
{
    protected $table = "kana_student";

    public function student(){
        return $this->belongsTo(User::class, 'student_id');
    }

    public function kana(){
        return $this->belongsTo(Kana::class, 'kana_id');
    }

    public function getLastReviewDateAttribute()
    {
        return $this->last_review;
    }

    public function getLevelAttribute()
    {
        return $this->level;
    }

    public function getHumanLevelAttribute()
    {
        return "HAHA";
    }
}
