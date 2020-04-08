<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class VocabularyWriting extends Model
{
    protected $table = "vocabulary_writing";

    public function vocabulary(){
        return $this->belongsTo(Vocabulary::class, 'vocabulary_id');
    }
}
