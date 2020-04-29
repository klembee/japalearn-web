<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class GrammarLearningPathQuestion extends Model
{
    protected $table = "grammar_learning_path_questions";

    public function grammarItem(){
        return $this->belongsTo(GrammarLearningPathItem::class, 'grammar_item_id');
    }

    public function answers(){
        return $this->hasMany(GrammarLearningPathAnswer::class, 'question_id');
    }
}
