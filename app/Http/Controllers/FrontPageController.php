<?php


namespace App\Http\Controllers;


use App\Models\BlogPost;
use App\Models\GrammarLearningPathCategory;
use App\Models\GrammarLearningPathItem;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class FrontPageController extends Controller
{
    public function home(Request $request){
        return view('frontpage.home');
    }

    public function grammar(Request $request){
        return $this->grammarCategory($request, GrammarLearningPathCategory::basic());
    }

    public function grammarCategory(Request $request, GrammarLearningPathCategory $category){
        $items = GrammarLearningPathItem::query()
            ->where('category_id', $category->id)->with('category')->paginate(5);
        $categories = GrammarLearningPathCategory::all();
        $currentCategoryId = $category->id;

        return view('frontpage.grammar', compact('items', 'categories', 'currentCategoryId'));
    }

    public function viewGrammar(Request $request, GrammarLearningPathItem $item){
        $markdownParser = new \Parsedown();
        $parsedContent = $markdownParser->text($item->content);

        return view('frontpage.viewGrammar', compact('item', 'parsedContent'));
    }

    public function stories(Request $request){
        // Show only 2 stories to free users
        $stories = Story::query()->limit(2)->get()->toArray();
        $stories = new LengthAwarePaginator(
            $stories,
            count($stories),
            5,
            $request->has('page') ? $request->input('page') : 1
        );

        return view('frontpage.stories', compact('stories'));
    }

    public function readStory(Request $request, Story $story){
        if($story->id >= 3 && env('APP_ENV') === 'production'){
            return redirect()->back();
        }

        $story = $story->load('vocab');


        return view('frontpage.viewStory', compact('story'));
    }

    public function blog(Request $request){
        $posts = BlogPost::query()->orderBy('created_at', 'desc')->paginate(5);

        return view('frontpage.blog', compact('posts'));
    }

    public function viewArticle(Request $request, BlogPost $post){

        $post = $post->load('author');

        return view('frontpage.viewArticle', compact('post'));
    }
}
