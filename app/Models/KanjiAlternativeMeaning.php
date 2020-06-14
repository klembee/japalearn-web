<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class KanjiAlternativeMeaning extends Model
{
    protected $table = "kanji_alternative_meaning";

    public function kanji(){
        return $this->belongsTo(KanjiLearningPath::class, 'kanji_id');
    }
}
