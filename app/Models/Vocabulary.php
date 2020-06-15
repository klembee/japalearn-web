<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Vocabulary extends Model
{
    use Searchable;

    protected $table = "vocabularies";

    protected $fillable = [
        'word',
    ];

    public function searchableAs()
    {
        return 'vocabularies';
    }

    public function toSearchableArray()
    {
        return [
            'word' => $this->word,
            // Remove words in parentisis
            'meanings' => $this->meanings->pluck(['meaning'])->toArray(),
            'writings' => $this->readings->pluck('writing')->toArray(),
            'number_of_save' => $this->usersThatSaved()->count()
            ];//$this->newQuery()->with('meanings', 'writings')->get()->toArray();
    }

    /**
     * Get the kanjis that makes this vocab
     */
    public function kanjis(){
        return $this->belongsToMany(KanjiLearningPath::class, 'kanji_vocabulary', 'vocabulary_id', 'kanji_id');
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
    public function readings(){
        return $this->hasMany(VocabularyReading::class, 'vocabulary_id');
    }
}
