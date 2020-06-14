<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class KanjiOnReading extends Model
{
    protected $table = "kanji_learning_path_on";

    protected $fillable = [
        'reading',
        'is_main'
    ];

    public function kanji(){
        return $this->belongsTo(KanjiLearningPath::class, 'kanji_id');
    }
}
