<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class VocabLearningPath extends Model
{
    protected $table = "vocab_learning_path";
    protected $fillable = ['word', 'level', 'word_type_id'];

    public function vocabulary(){
        return $this->belongsTo(Vocabulary::class);
    }
}
