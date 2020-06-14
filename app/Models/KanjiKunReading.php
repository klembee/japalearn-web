<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class KanjiKunReading extends Model
{
    protected $table = "kanji_learning_path_kun";

    protected $fillable = [
        'reading',
        'is_main'
    ];

    public function kanji(){
        return $this->belongsTo(KanjiLearningPath::class, 'kanji_id');
    }
}
