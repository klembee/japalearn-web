<?php


namespace App\Models;


use App\Interfaces\Learnable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class VocabLearningPath extends Model
{
    protected $table = "vocab_learning_path";
    protected $fillable = ['word', 'level', 'word_type_id', 'mnemonic'];
    protected $appends = [
        'answers',
        'type',
        'student_level'
    ];



    public function getTypeAttribute(){
        return WordType::query()->where('id', $this->word_type_id)->firstOrFail()->name;
    }

    public function vocabulary(){
        return $this->belongsTo(Vocabulary::class);
    }

    public function onReadings(){
        return $this->hasMany(KanjiOnReading::class, 'kanji_id');
    }

    public function kunReadings(){
        return $this->hasMany(KanjiKunReading::class, 'kanji_id');
    }

    public function readings(){
        return $this->hasMany(VocabLearningPathReadings::class, 'vocab_learning_path_item_id');
    }

    public function meanings(){
        return $this->hasMany(VocabLearningPathMeanings::class, 'vocab_learning_path_item_id');
    }

    public function otherMeanings(){
        return $this->hasMany(KanjiAlternativeMeaning::class, 'kanji_id');
    }

    public function examples(){
        return $this->hasMany(VocabLearningPathExample::class, "vocab_learning_path_item_id");
    }

    public function radicals(){
        if($this->word_type_id != WordType::kanji()->id){
            error_log("Trying to get radicals of non kanji item");
            return $this->newQuery();
        }

        return $this->belongsToMany(Radical::class, 'kanji_radical', 'kanji_id', 'radical_id');
    }

    public function getStudentLeveLAttribute(){
        if(!Auth::user() or !Auth::user()->isStudent()){
            return 0;
        }else{
            $user = Auth::user();

            $stat = VocabLearningPathItemStats::query()
                ->where('student_info_id', $user->info->id)
                ->where('learning_path_item_id', $this->id)->first();

            if($stat && $stat->exists()){
//                error_log("STATS FOUND");
                return $stat->nb_right;
            }else{
//                error_log("No stats found");
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
