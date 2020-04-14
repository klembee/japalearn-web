<?php


namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StudentInfo extends Model
{
    protected $table = "student_info";
    protected $appends = ['number_reviews', 'number_lessons'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function vocabLearningPathStats(){
        return $this->hasMany(VocabLearningPathItemStats::class, 'student_info_id');
    }

    public function getNumberLessonsAttribute(){
        $vocabToLearn = $this->getVocabLessonItems();

        return count($vocabToLearn['radicals']) + count($vocabToLearn['kanjis']) + count($vocabToLearn['vocabulary']);
    }

    public function getNumberReviewsAttribute(){
        $vocabToLearn = $this->getVocabReviewItems();
        return $vocabToLearn['count'];
    }

    public function getVocabReviewItems(){
        $allReviews = $this->vocabLearningPathStats()->with('vocabLearningPathItem', 'vocabLearningPathItem.meanings', 'vocabLearningPathItem.readings')->get();
        $reviewsToDo = [
            'writing' => [],
            'meaning' => []
        ];

        $now = Carbon::now();

        foreach ($allReviews as $review){
            $meaningLastDate = $review->meaning_last_right_date;
            $writingLastDate = $review->writing_last_right_date;
            $level = $review->level;
            $timeToWait = VocabLearningPathItemStats::$levels_interval[$level - 1];


            if(!$meaningLastDate){
                array_push($reviewsToDo['meaning'], $review->toArray());
            }
            if(!$writingLastDate && $review->vocabLearningPathItem->word_type_id != WordType::radical()->id){
                array_push($reviewsToDo['writing'], $review->toArray());
            }

            $timeDiffMeaning = $now->copy()->diffInHours($meaningLastDate);
            error_log($timeDiffMeaning);
            if($writingLastDate) {
                $timeDiffWriting = $now->copy()->diffInHours($writingLastDate);

                if($timeDiffWriting >= $timeToWait){
                    array_push($reviewsToDo['writing'], $review->toArray());
                }
            }

            if($timeDiffMeaning >= $timeToWait){
                array_push($reviewsToDo['meaning'], $review->toArray());
            }
        }

        return [
            'count' => count($reviewsToDo['writing']) + count($reviewsToDo['meaning']),
            'review' => $reviewsToDo
        ];
    }



    public function getVocabLessonItems(){
        $currentVocabItemsUnderLevel3 = $this->vocabLearningPathStats()->get()->filter(function($value, $key){
            return $value->level <= 3;
        });

        $toLearn = 20 - $currentVocabItemsUnderLevel3->count();

        $allItemsCurrentLevel = VocabLearningPath::query()->where('level', $this->level)->with('readings', 'meanings');
        $allItemsAlreadyLearnedThisLevel = $this->vocabLearningPathStats()->whereHas('vocabLearningPathItem', function($query){
            return $query->where('level', $this->level);
        })->with('vocabLearningPathItem')->get()->pluck('vocabLearningPathItem.id');

        error_log("Already learned: " . json_encode($allItemsAlreadyLearnedThisLevel));

        # The radicals have to be learned first
        if($toLearn > 0) {
            $allRadicalsCurrentLevel = (clone $allItemsCurrentLevel)
                ->where('word_type_id', WordType::radical()->id)
                ->whereNotIn('id', $allItemsAlreadyLearnedThisLevel)
                ->limit($toLearn)->get();

            $toLearn -= $allRadicalsCurrentLevel->count();
        }else{
            $allRadicalsCurrentLevel = collect([]);
        }

        # The kanjis have to be learned second
        if($toLearn > 0) {
            $allKanjisCurrentLevel = (clone $allItemsCurrentLevel)
                ->where('word_type_id', WordType::kanji()->id)
                ->whereNotIn('id', $allItemsAlreadyLearnedThisLevel)
                ->limit($toLearn)->get();

            $toLearn -= $allRadicalsCurrentLevel->count();
        }else{
            $allKanjisCurrentLevel = collect([]);
        }

        if($toLearn > 0) {
            $allVocabularyCurrentLevel = (clone $allItemsCurrentLevel)
                ->where('word_type_id', WordType::vocabulary()->id)
                ->whereNotIn('id', $allItemsAlreadyLearnedThisLevel)
                ->limit($toLearn)->get();

            $toLearn -= $allRadicalsCurrentLevel->count();
        }else{
            $allVocabularyCurrentLevel = collect([]);;
        }

        return [
            'radicals' => $allRadicalsCurrentLevel,
            'kanjis' => $allKanjisCurrentLevel,
            'vocabulary' => $allVocabularyCurrentLevel
        ];
    }
}
