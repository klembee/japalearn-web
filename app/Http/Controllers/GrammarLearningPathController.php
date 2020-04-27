<?php


namespace App\Http\Controllers;


use App\Models\GrammarLearningPathCategory;
use Illuminate\Http\Request;

class GrammarLearningPathController extends Controller
{
    public function index(Request $request){
        $categories = GrammarLearningPathCategory::query()->get();


        return view('app.grammar_learning_path.index', compact('categories'));
    }

    public function viewCategory(Request $request, GrammarLearningPathCategory $category){
        $items = $category->items;

        return view('app.grammar_learning_path.view_category', compact('items', 'category'));
    }
}
