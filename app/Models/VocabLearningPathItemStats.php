<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class VocabLearningPathItemStats extends Model
{
    protected $table = "vocab_learning_path_item_student";
    protected $appends = ['level', 'human_level'];
    protected $dates = [
        'writing_last_right_date',
        'meaning_last_right_date'];

    public static $levels_interval = [4, 8, 24, 72, 168, 336, 720, 2880]; # In hours

    public function student(){
        return $this->belongsTo(User::class);
    }

    public function vocabLearningPathItem(){
        return $this->belongsTo(VocabLearningPath::class, 'learning_path_item_id');
    }

    public function getLevelAttribute(){
        // Radicals don't have writings
        if($this->vocabLearningPathItem->word_type_id == WordType::radical()->id){
            return $this->meaning_right;
        }

        return min($this->writing_right, $this->meaning_right);
    }

    public function getHumanLevelAttribute() {
        if ($this->level < 0) return 'Inactive';
        if ($this->level <= 3) return 'Apprentice';
        if ($this->level <= 5) return 'Guru';
        if ($this->level <= 6) return 'Master';
        if ($this->level <= 7) return 'Enlightened';
        return 'Burned';
    }
}
