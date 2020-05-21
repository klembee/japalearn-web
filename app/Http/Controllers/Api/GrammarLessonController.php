<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\GrammarLearningPathItem;
use Illuminate\Http\Request;

class GrammarLessonController extends Controller
{
    public function updateLevel(Request $request){
        $this->validate($request, [
            'grammar_id' => 'required'
        ]);

        $grammar_item = GrammarLearningPathItem::query()->where('id', $request->input('grammar_id'))->firstOrFail();
        $user = $request->user();

        $user->info->information->grammarItemsDone()->attach($grammar_item->id, [
            'date_done' => now()
        ]);

        return response()->json([
            'success' => true
        ]);
    }
}
