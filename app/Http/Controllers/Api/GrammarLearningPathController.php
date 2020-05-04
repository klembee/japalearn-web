<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\GrammarLearningPathAnswer;
use App\Models\GrammarLearningPathItem;
use App\Models\GrammarLearningPathQuestion;
use Illuminate\Http\Request;

class GrammarLearningPathController extends Controller
{
    /**
     * Create a new grammar lesson item
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addGrammarLesson(Request $request){

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

    /**
     * Update a grammar lesson item
     * @param Request $request
     * @param GrammarLearningPathItem $item
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateGrammarLesson(Request $request, GrammarLearningPathItem $item){
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'questions' => 'nullable|array'
        ]);

        try {
            $item->title = $request->input('title');
            $item->content = $request->input('content');
            $item->save();

            // Delete the questions before recreating them
            $item->questions()->delete();

            // Save the questions
            foreach($request->input('questions') as $question){
                $q = new GrammarLearningPathQuestion($question);
                $q->grammar_item_id = $item->id;
                $q->save();

                foreach($question['answers'] as $answer){
                    $a = new GrammarLearningPathAnswer($answer);
                    $a->question_id = $q->id;
                    $a->save();
                }
            }
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

    /**
     * Delete a single question from a grammar
     * learning path item
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function deleteQuestion(Request $request){

        $this->validate($request, [
            'question_id' => 'required'
        ]);

        $question = GrammarLearningPathQuestion::query()->where('id', $request->input('question_id'))->firstOrFail();

        try {
            $question->delete();
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => "Failed to delete question"
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }
}
