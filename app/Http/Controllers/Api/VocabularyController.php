<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Vocabulary;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    public function add(Request $request){
        $this->authorize('add', Vocabulary::class);
        $this->validate($request, [
            'vocabulary_id' => 'required'
        ]);

        $vocab = Vocabulary::query()->where('id', $request->input('vocabulary_id'))->firstOrFail();
        $student = $request->user();

        try{
            $student->vocabulary()->attach([$vocab->id]);

            # Update on Algolia
            $vocab->save();
        }catch (QueryException $e){
            if($e->errorInfo[1] == 1062){
                return response()->json([
                    'error' => __("This word is already in your vocabulary")
                ]);
            }else{
                return response()->json([
                    'error' => __("Error while adding to vocabulary")
                ]);
            }
        }


        return $vocab;
    }
}
