<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\GrammarLearningPathItem;
use Illuminate\Http\Request;

class GrammarLearningPathController extends Controller
{
    public function addGrammarLesson(Request $request){
        error_log(print_r($request->all(), true));

        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required'
        ]);

        $item = new GrammarLearningPathItem([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'category_id' => $request->input('category_id')
        ]);
        $item->save();


        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }

    public function updateGrammarLesson(Request $request, GrammarLearningPathItem $item){
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ]);

        try {
            $item->title = $request->input('title');
            $item->content = $request->input('content');
            $item->save();
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => "Failed to update grammar lesson"
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }
}
