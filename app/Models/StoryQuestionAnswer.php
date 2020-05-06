<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class StoryQuestionAnswer extends Model
{
    protected $table = "story_question_answer";

    public function question(){
        return $this->belongsTo(StoryQuestion::class);
    }
}
