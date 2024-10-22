<?php


namespace App\Http\Controllers\Api;


use App\Events\KanjiLeveledUp;
use App\Http\Controllers\Controller;
use App\Models\ActivityType;
use App\Models\GrammarLearningPathItem;
use App\Models\StudentActivity;
use App\Models\KanjiLearningPath;
use App\Models\VocabLearningPathExample;
use App\Models\KanjiLearningPathItemStats;
use App\Models\KanjiLearningPathMeanings;
use App\Models\Vocabulary;
use App\Models\WordType;
use http\Client\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


/**
 * Api controller that controls learning path controller related stuff.
 * Like creating a new item or leveling up the item attached to a user
 *
 * Class KanjiAdminController
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
            "meanings" => "required|array",
            "readings" => "present|array",
        ]);

        //todo: Verify that the user is an admin

        $word = $request->input('word');
        $level = $request->input('level');
        $meanings = $request->input('meanings');
        $readings = $request->input('readings');

        $vocabLearningPathItem = new KanjiLearningPath([
            'word' => $word,
            'level' => $level
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
     * Update an existing vocab learning path item
     * @param Request $request
     * @param KanjiLearningPath $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateItem(Request $request, KanjiLearningPath $item){

        $this->validate($request, [
            'word' => "required",
        ]);

        $word = $request->input('word');
        $mnemonic = $request->input('mnemonic');
        $vocab = $request->input('vocab');
        $meanings = $request->input('meanings');
        $onReadings = $request->input('onReadings');
        $kunReadings = $request->input('kunReadings');
        $level = $request->input('level');


        try {
            DB::transaction(function() use(&$item, $word, $mnemonic, $meanings, $onReadings, $kunReadings, $vocab, $level){
                $item->word = $word;
                $item->mnemonic = $mnemonic;
                $item->level = $level;

                foreach($vocab as $voc){
                    $item->vocab()->updateExistingPivot($voc['id'], ['is_primary' => $voc['pivot']['is_primary']], false);
                }

                $item->meanings()->delete();
                foreach($meanings as $meaning){
                    // If the id is not present, it means its a new meaning
                    $item->meanings()->create([
                        'meaning' => $meaning['meaning'],
                        'is_main' => $meaning['is_main']
                    ]);
                }

                $item->onReadings()->delete();
                foreach($onReadings as $reading){
                    $item->onReadings()->create([
                        'reading' => $reading['reading'],
                        'is_main' => $reading['is_main']
                    ]);
                }

                $item->kunReadings()->delete();
                foreach($kunReadings as $reading){
                    $item->kunReadings()->create([
                        'reading' => $reading['reading'],
                        'is_main' => $reading['is_main']
                    ]);
                }


                $item->save();
            });

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }

    /**
     * Delete a specific vocab learning path item
     * @param Request $request
     * @param KanjiLearningPath $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteItem(Request $request, KanjiLearningPath $item){
        try {
            $item->delete();
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => ""
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
        //todo: Verify that the user waited ennough time to update this level

        $this->validate($request, [
            'good' => "present|array",
            'wrong' => 'present|array'
        ]);

        $goodItems = $request->input('good');
        $wrongItems = $request->input('wrong');

        $nbNewlyLearnedItems = 0;
        $nbReviewedItems = 0;

        // Go through each items that the user got right and increase the level
        foreach($goodItems as $good){
            $word = $good['question'];

            $itemStats = $user->info->kanjiLearningPathStats()->whereHas('kanjiLearningPathItem', function($query) use($word){
                return $query->where('word', $word);
            })->get();

            try {
                $item = KanjiLearningPath::query()->where('word', $word)->firstOrFail();

                if ($itemStats->count() > 0) {
                    // Edit
                    $stat = KanjiLearningPathItemStats::query()
                        ->where('learning_path_item_id', $item->id)
                        ->where('student_info_id', $user->info->id)->firstOrFail();

                    $stat->nb_right += 1;
                    $stat->nb_tries += 1;
                    $stat->last_study_date = now();

                    $stat->save();
                    $nbReviewedItems += 1;
                } else {
                    // Create new item stat
                    $stat = new KanjiLearningPathItemStats;
                    $stat->learning_path_item_id = $item->id;
                    $stat->student_info_id = $user->info->id;

                    $stat->nb_right = 1;
                    $stat->last_study_date = now();

                    $stat->save();
                    $nbNewlyLearnedItems += 1;
                }
            }catch (\Exception $e){
                error_log($e->getMessage());
            }
        }

        $studentInformation = $user->info;
        if($nbReviewedItems > 0){
            $studentActivity = new StudentActivity([
                'nb_items' => $nbReviewedItems
            ]);
            $studentActivity->student_info_id = $studentInformation->id;
            $studentActivity->activity_type_id = ActivityType::kanjiReviewed()->id;
            $studentActivity->save();
        }
        if($nbNewlyLearnedItems > 0){
            $studentActivity = new StudentActivity([
                'nb_items' => $nbNewlyLearnedItems
            ]);
            $studentActivity->student_info_id = $studentInformation->id;
            $studentActivity->activity_type_id = ActivityType::kanjiLearned()->id;
            $studentActivity->save();
        }

        // Go Through each items that the user got wrong and update the study date to now
        foreach($wrongItems as $wrong) {

            $stat = KanjiLearningPathItemStats::query()
                ->where('learning_path_item_id', $wrong['id'])
                ->where('student_info_id', $user->info->id);

            error_log($stat->exists());

            if($stat->exists()) {
                $stat = $stat->firstOrFail();
                $stat->last_study_date = now();
                $stat->nb_tries += 1;

                if($stat->nb_right > 1){
                    $stat->nb_right -= 1;
                }

                $stat->save();
            }

        }


        // Check if the student leveled up
        $currentKanjiLevel = $user->info->kanji_level;
        $levelUp = true;
        $kanjisThisLevel = KanjiLearningPath::query()
            ->where('level', $currentKanjiLevel)->get();

        $itemsDones = $user->info->kanjiLearningPathStats->pluck('learning_path_item_id')->toArray();

        foreach($kanjisThisLevel as $kanji){
            if($kanji->student_level < 5){
                $levelUp = false;
                break;
            }
            if(!in_array($kanji->id, $itemsDones)){
                $levelUp = false;
                break;
            }
        }

        if($levelUp){
            // Sent event
            $userInfo = $user->info;
            $userInfo->kanji_level += 1;
            $userInfo->save();

            event(new KanjiLeveledUp($user, $currentKanjiLevel + 1));
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function getLevelOverview(Request $request){
        $user = $request->user();

        $kanjis = KanjiLearningPath::query()
            ->where('level', $user->info->kanji_level)->get()->sortByDesc('student_level')->toArray();

        return \response()->json([
            'success' => true,
            'kanjis' => array_values($kanjis)
        ]);
    }
}
