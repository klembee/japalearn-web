<?php


namespace App\Http\Controllers;


use App\Models\GrammarLearningPathCategory;
use App\Models\GrammarLearningPathItem;
use Illuminate\Http\Request;

class GrammarLearningPathController extends Controller
{
    public function index(Request $request){
        $categories = GrammarLearningPathCategory::query()->get();


        return view('app.admin.grammar_learning_path.index', compact('categories'));
    }

    /**
     * Allows an admin to edit the grammar learning path item
     * @param Request $request
     * @param GrammarLearningPathItem $item
     */
    public function edit(Request $request, GrammarLearningPathItem $item){
        $item = $item->load('questions', 'questions.answers');

        return view('app.admin.grammar_learning_path.edit', compact('item'));
    }

    /**
     * Apply the changes from the edit method
     * @param Request $request
     * @param GrammarLearningPathItem $item
     */
    public function update(Request $request, GrammarLearningPathItem $item){

    }

    public function viewCategory(Request $request, GrammarLearningPathCategory $category){
        $items = $category->items;

        return view('app.admin.grammar_learning_path.view_category', compact('items', 'category'));
    }
}
