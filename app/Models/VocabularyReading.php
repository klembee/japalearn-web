<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class VocabularyReading extends Model
{
    protected $table = "vocabulary_writing";

    protected $fillable = [
        'writing',
        'mnemonic',
    ];

    public function vocabulary(){
        return $this->belongsTo(Vocabulary::class, 'vocabulary_id');
    }
}
