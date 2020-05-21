<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class VocabLearningPathMeanings extends Model
{
    protected $table = "vocab_learning_path_meanings";

    protected $fillable = [
        'meaning',
        'vocab_learning_path_item_id',
        'is_main'
    ];

    public function learningPathItem(){
        return $this->belongsTo(VocabLearningPath::class, "vocab_learning_path_item_id");
    }
}
