<?php


namespace App\Http\Controllers;


use App\Helpers\GrammarHelper;
use App\Http\Controllers\Controller;
use App\Models\GrammarLearningPathCategory;
use App\Models\GrammarLearningPathItem;
use Illuminate\Http\Request;

class GrammarController extends Controller
{

    /**
     * Show stats about the users and the grammar items he/she has learned
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $categories = GrammarLearningPathCategory::query()->orderBy('order')->get();
        $nextItem = GrammarHelper::getNextItem();

        return view('app.grammar.index', compact('categories', 'nextItem'));
    }


    public function learn(Request $request, GrammarLearningPathItem $item){
        $markdownParser = new \Parsedown();
        $parsedContent = $markdownParser->text($item->content);

        return view('app.grammar.learn', compact('item', 'parsedContent'));
    }
}
