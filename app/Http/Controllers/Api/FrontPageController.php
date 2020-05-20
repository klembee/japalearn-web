<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\GrammarLearningPathItem;
use Illuminate\Http\Request;

class FrontPageController extends Controller
{
    public function latestArticles(Request $request){
        return response()->json([
            'success' => true,
            'articles' => BlogPost::query()->orderBy('created_at', 'desc')->limit(3)->get()
        ]);
    }

    public function randomGrammarLessons(Request $request){
        return response()->json([
            'success' => true,
            'items' => GrammarLearningPathItem::query()->get()->random(3)
        ]);
    }
}
