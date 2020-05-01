<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class GrammarLearningPathAnswer extends Model
{
    protected $table = "grammar_learning_path_question_answer";
    protected $fillable = [
        'answer'
    ];

    public function question(){
        return $this->belongsTo(GrammarLearningPathQuestion::class, 'question_id');
    }
}
