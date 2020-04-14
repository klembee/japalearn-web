<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\VocabLearningPath;
use App\Models\VocabLearningPathItemStats;
use App\Models\Vocabulary;
use App\Models\WordType;
use http\Client\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;


class LearningPathController extends Controller
{
    public function newItem(Request $request){
        $this->validate($request, [
            "word" => "required",
            "level" => "required|numeric|min:1",
            "type" => "required",
            "meanings" => "required|array",
            "readings" => "present|array",
        ]);

        $word = $request->input('word');
        $wordType = $request->input('type');
        $level = $request->input('level');
        $meanings = $request->input('meanings');
        $readings = $request->input('readings');

        $vocabLearningPathItem = new VocabLearningPath([
            'word' => $word,
            'level' => $level,
            'word_type_id' => WordType::query()->where('name', $wordType)->firstOrFail()->id,
        ]);


        try {
            $vocabLearningPathItem->save();

            foreach ($meanings as $meaning){
                $vocabLearningPathItem->meanings()->create([
                    'meaning' => $meaning
                ]);
            }

            foreach ($readings as $reading){
                $vocabLearningPathItem->readings()->create([
                    'reading' => $reading
                ]);
            }
        }catch(QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                // Unique error
                return \response()->json([
                    'success' => false,
                    'message' => "Item already exists in another level"
                ]);
            }
        }

        return \response()->json([
            'success' => true,
        ]);
    }

    /**
     * Updates the level of the items after reviewing them
     *
     * @param Request $request
     * @return string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateLevel(Request $request){
        $user = $request->user();
        //todo: check that user is a student
        $this->validate($request, [
            'good' => "present|array",
            'wrong' => 'present|array'
        ]);

        $goodItems = $request->input('good');
        $wrongItems = $request->input('wrong');

        foreach($goodItems as $good){
            $word = $good['question'];
            error_log($word);

            $itemStats = $user->userInfo->vocabLearningPathStats()->whereHas('vocabLearningPathItem', function($query) use($word){
                return $query->where('word', $word);
            })->get();

            try {
                $item = VocabLearningPath::query()->where('word', $word)->firstOrFail();

                error_log($itemStats->count());

                if ($itemStats->count() > 0) {
                    // Edit
                    $stat = VocabLearningPathItemStats::query()
                        ->where('learning_path_item_id', $item->id)
                        ->where('student_info_id', $user->userInfo->id)->firstOrFail();

                    if ($good['type'] == "meaning") {
                        $stat->meaning_right += 1;
                        $stat->meaning_last_right_date = now();
                    } else if ($good['type'] == "reading") {
                        $stat->reading_right += 1;
                        $stat->reading_last_right_date = now();
                    }

                    $stat->save();
                } else {
                    // Create new item stat
                    $stat = new VocabLearningPathItemStats;
                    $stat->learning_path_item_id = $item->id;
                    $stat->student_info_id = $user->userInfo->id;

                    if ($good['type'] == "meaning") {
                        $stat->meaning_right = 1;
                        $stat->meaning_last_right_date = now();
                    } else if ($good['type'] == "reading") {
                        $stat->reading_right = 1;
                        $stat->reading_last_right_date = now();
                    }

                    $stat->save();
                }
            }catch (\Exception $e){
                error_log($e->getMessage());
            }

        }
        print("WRONG:");
        foreach($wrongItems as $wrong) {
            $word = $wrong['question'];
            $itemStats = $user->userInfo->vocabLearningPathStats()->whereHas('vocabLearningPathItem', function($query) use($word){
                return $query->where('word', $word);
            })->get();

            $stat = VocabLearningPathItemStats::query()
                ->where('learning_path_item_id', $item->id)
                ->where('student_info_id', $user->userInfo->id)->firstOrFail();

            if ($wrong['type'] == "meaning") {
                if($stat->meaning_right > 1) {
                    $stat->meaning_right -= 1;
                    $stat->meaning_last_right_date = now();
                }
            } else if ($wrong['type'] == "reading") {
                if($stat->reading_right > 1) {
                    $stat->reading_right -= 1;
                }
                $stat->reading_last_right_date = now();
            }

            $stat->save();

        }

        return "ASDF";
    }
}
