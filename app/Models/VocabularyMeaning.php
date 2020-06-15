<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class VocabularyMeaning extends Model
{
    protected $table = "vocabulary_meaning";

    protected $fillable = [
        'meaning',
        'mnemonic',
        'indication'
    ];

    public function vocabulary(){
        return $this->belongsTo(Vocabulary::class, 'vocabulary_id');
    }
}
