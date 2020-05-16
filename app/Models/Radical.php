<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Radical extends Model
{
    protected $table = "radicals";
    protected $fillable = [
        'radical'
    ];

    public function kanjis(){
        return $this->belongsToMany(VocabLearningPath::class, 'kanji_radical', 'radical_id', 'kanji_id');
    }
}
