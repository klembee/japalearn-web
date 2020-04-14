<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Vocabulary extends Model
{
    use Searchable;

    protected $table = "vocabularies";

    public function searchableAs()
    {
        return 'vocabularies';
    }

    public function toSearchableArray()
    {
        return [
            'word' => $this->word,
            'commonity' => $this->commonity,
            // Remove words in parentisis
            'meanings' => $this->meanings->pluck(['meaning'])->toArray(),
            'writings' => $this->writings->pluck('writing')->toArray(),
            'pos' => $this->pos()->pluck('pos')->toArray(),
            'number_of_save' => $this->usersThatSaved()->count()
            ];//$this->newQuery()->with('meanings', 'writings')->get()->toArray();
    }

    public function usersThatSaved(){
        return $this->belongsToMany(
            User::class,
            'student_vocabulary',
            'vocabulary_id',
            'student_id');
    }

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
