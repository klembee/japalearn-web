<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class StoryQuestion extends Model
{
    protected $table = "story_question";

    public function answer(){
        return $this->hasMany(StoryQuestionAnswer::class);
    }

    public function story(){
        return $this->belongsTo(Story::class);
    }
}
