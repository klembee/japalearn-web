<?php


namespace App\Http\Controllers;


use App\Helpers\GrammarHelper;
use App\Helpers\SubscriptionHelper;
use App\Http\Controllers\Controller;
use App\Models\GrammarLearningPathCategory;
use App\Models\GrammarLearningPathItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $currentCategory = Auth::user()->info->current_grammar_category;

        return view('app.grammar.index', compact('categories', 'nextItem', 'currentCategory'));
    }


    public function learn(Request $request, GrammarLearningPathItem $item){
        if($item->subscriber_only){
            if(!SubscriptionHelper::isSubscribed($request)){
                // This user is not a paying customer...
                return redirect()->route('account.subscription.index');
            }
        }

        $markdownParser = new \Parsedown();
        $parsedContent = $markdownParser->text($item->content);

        $item = $item->load('vocab');

        return view('app.grammar.learn', compact('item', 'parsedContent'));
    }

    public function review(Request $request, GrammarLearningPathItem $grammarlesson){
        if($grammarlesson->subscriber_only){
            if(!SubscriptionHelper::isSubscribed($request)){
                // This user is not a paying customer...
                return redirect()->route('account.subscription.index');
            }
        }


        $questions = $grammarlesson->questions()->with('answers')->get()->toArray();

        if(count($questions) == 0){
            $request->session()->flash('error', "This grammar lesson doesn't have any questions yet !");
            return redirect()->route('grammar.learn', $grammarlesson);
        }

        $nextLessonId = $grammarlesson->id + 1;
        $nextLessonModel = GrammarLearningPathItem::query()->where('id', $nextLessonId);
        $nextLesson = null;

        if($nextLessonModel->exists()){
            $nextLesson = $nextLessonModel->first();
        }

        shuffle($questions);
        $questions = array_map(function($question){
            $question['answers'] = array_column($question['answers'], 'answer');
            return $question;
        }, $questions);

        return view('app.study.grammar_exercise', compact('grammarlesson', 'questions', 'nextLesson'));
    }
}
