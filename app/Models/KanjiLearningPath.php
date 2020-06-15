<?php


namespace App\Models;


use App\Interfaces\Learnable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class KanjiLearningPath extends Model
{
    protected $table = "kanji_learning_path";
    protected $fillable = ['word', 'level', 'mnemonic'];
    protected $appends = [
        'answers',
        'student_level'
    ];

    public function onReadings(){
        return $this->hasMany(KanjiOnReading::class, 'kanji_id');
    }

    public function kunReadings(){
        return $this->hasMany(KanjiKunReading::class, 'kanji_id');
    }

    public function meanings(){
        return $this->hasMany(KanjiLearningPathMeanings::class, 'kanji_id');
    }

    public function otherMeanings(){
        return $this->hasMany(KanjiAlternativeMeaning::class, 'kanji_id');
    }

    /**
     * Get the vocabulary that uses this kanji
     */
    public function vocab(){
        return $this->belongsToMany(Vocabulary::class, 'kanji_vocabulary', 'kanji_id', 'vocabulary_id')
            ->with('meanings', 'readings')
            ->withPivot(['is_primary', 'id']);
    }

    public function getStudentLeveLAttribute(){
        if(!Auth::user() or !Auth::user()->isStudent()){
            return 0;
        }else{
            $user = Auth::user();

            $stat = KanjiLearningPathItemStats::query()
                ->where('student_info_id', $user->info->id)
                ->where('learning_path_item_id', $this->id)->first();

            if($stat && $stat->exists()){
                return $stat->nb_right;
            }else{
                return 0;
            }
        }
    }

    public function getAnswersAttribute(){
        if($this->word_type_id == WordType::radical()->id){
            return $this->meanings->pluck('meaning');
        }else{
            return [
                'meanings' => $this->meanings->pluck('meaning'),
                'readings' => $this->onReadings->pluck('reading')->concat($this->kunReadings->pluck('reading'))
            ];
        }
    }

}
