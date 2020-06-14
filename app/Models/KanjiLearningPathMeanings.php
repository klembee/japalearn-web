<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class KanjiLearningPathMeanings extends Model
{
    protected $table = "kanji_learning_path_meanings";

    protected $fillable = [
        'meaning',
        'kanji_id',
        'is_main'
    ];

    public function kanji(){
        return $this->belongsTo(KanjiLearningPath::class, "kanji_id");
    }
}
