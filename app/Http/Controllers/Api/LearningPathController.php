<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\VocabLearningPath;
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
            "type" => "required"
        ]);

        $word = $request->input('word');
        $wordType = $request->input('type');
        $level = $request->input('level');


        error_log($wordType);

        $vocabLearningPathItem = new VocabLearningPath([
            'word' => $word,
            'level' => $level,
            'word_type_id' => WordType::query()->where('name', $wordType)->firstOrFail()->id,
        ]);

        try {
            $vocabLearningPathItem->save();
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
}
