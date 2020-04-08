<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    protected $table = "vocabularies";

    /**
     * Get the meanings of this word
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meanings(){
        return $this->hasMany(VocabularyMeaning::class, 'vocabulary_id');
    }

    /**
     * Get the writings of this word
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function writings(){
        return $this->hasMany(VocabularyWriting::class, 'vocabulary_id');
    }

    /**
     * Get the part of speech of this words. Can have more than one !
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pos(){
        return $this->belongsToMany(VocabularyPOS::class, 'vocabulary_pos', 'vocabulary_id', 'pos_id');
    }
}
