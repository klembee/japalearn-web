<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class VocabLearningPathReadings extends Model
{
    protected $table = "vocab_learning_path_readings";
    protected $fillable = ['reading', 'vocab_learning_path_item_id'];


    public function learningPathItem(){
        return $this->belongsTo(VocabLearningPath::class, "vocab_learning_path_item_id");
    }
}
