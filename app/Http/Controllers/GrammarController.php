<?php


namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\GrammarLearningPathCategory;
use Illuminate\Http\Request;

class GrammarController extends Controller
{
    public function index(Request $request){
        $categories = GrammarLearningPathCategory::query()->orderBy('order')->get();

        return view('app.grammar.index', compact('categories'));
    }
}
