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


/**
 * Api controller that controls learning path controller related stuff.
 * Like creating a new item or leveling up the item attached to a user
 *
 * Class LearningPathController
 * @package App\Http\Controllers\Api
 */
class LearningPathController extends Controller
{

    /**
     * Allow an admin to create a new learning path item.
     * The item can be of type 'radical', 'kanji' or 'vocabulary'
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function newItem(Request $request){
        $this->validate($request, [
            "word" => "required",
            "level" => "required|numeric|min:1",
            "type" => "required",
            "meanings" => "required|array",
            "readings" => "present|array",
        ]);

        //todo: Verify that the user is an admin

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
     * Updates the level of the items after a user
     * reviewed them. If the user got it wrong, it stays at the
     * same level and the user have to wait the same time. If the user
     * got it right, it increases the level by one and the user have to wait longer
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

        // Go through each items that the user got right and increase the level
        foreach($goodItems as $good){
            $word = $good['question'];

            $itemStats = $user->userInfo->vocabLearningPathStats()->whereHas('vocabLearningPathItem', function($query) use($word){
                return $query->where('word', $word);
            })->get();

            try {
                $item = VocabLearningPath::query()->where('word', $word)->firstOrFail();

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

        // Go Through each items that the user got wrong and update the study date to now
        foreach($wrongItems as $wrong) {
            $word = $wrong['question'];
            $itemStats = $user->userInfo->vocabLearningPathStats()->whereHas('vocabLearningPathItem', function($query) use($word){
                return $query->where('word', $word);
            })->get();

            $stat = VocabLearningPathItemStats::query()
                ->where('learning_path_item_id', $item->id)
                ->where('student_info_id', $user->userInfo->id)->firstOrFail();

            if ($wrong['type'] == "meaning") {
                $stat->meaning_last_right_date = now();
            } else if ($wrong['type'] == "reading") {
                $stat->reading_last_right_date = now();
            }

            $stat->save();

        }

        return response()->json([
            'success' => true
        ]);
    }
}
