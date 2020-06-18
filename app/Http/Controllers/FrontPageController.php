<?php


namespace App\Http\Controllers;


use App\Mail\SendGift;
use App\Models\BlogPost;
use App\Models\Gift;
use App\Models\GrammarLearningPathCategory;
use App\Models\GrammarLearningPathItem;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;

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
            ->where('subscriber_only', false)
            ->where('category_id', $category->id)->with('category')->paginate(5);
        $categories = GrammarLearningPathCategory::all();
        $currentCategoryId = $category->id;

        return view('frontpage.grammar', compact('items', 'categories', 'currentCategoryId'));
    }

    public function viewGrammar(Request $request, GrammarLearningPathItem $item){
        // Todo check that user is subscribed and can read item

        $markdownParser = new \Parsedown();
        $parsedContent = $markdownParser->text($item->content);

        $item = $item->load('vocab');

        return view('frontpage.viewGrammar', compact('item', 'parsedContent'));
    }

    public function privacyPolicy(Request $request){
        return view('frontpage.privacyPolicy');
    }

    public function termsConditions(Request $request){
        return view('frontpage.termsAndConditions');
    }

    public function stories(Request $request){
        // Show only 2 stories to free users
        $stories = Story::query()->where('subscriber_only', false)->limit(2)->get()->toArray();
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

        $otherArticles = BlogPost::query()->where('id', '!=', $post->id)->get();
        $nbOther = min(count($otherArticles), 3);
        $otherArticles = $otherArticles->random($nbOther);

        return view('frontpage.viewArticle', compact('post', 'otherArticles'));
    }

    public function viewArticleAMP(Request $request, BlogPost $post){
        $post = $post->load('author');

        $otherArticles = BlogPost::query()->where('id', '!=', $post->id)->get();
        $nbOther = min(count($otherArticles), 3);
        $otherArticles = $otherArticles->random($nbOther);

        $markdownParser = new \Parsedown();
        $parsedContent = str_replace('<img', '<amp-img width="300" height="200" layout="responsive" ', $markdownParser->text($post->content));

        return view('frontpage.amp.viewArticle', compact('post', 'otherArticles', 'parsedContent'));
    }

    public function takeGift(Request $request, Gift $gift){
        $gift = $gift->load('documents');

        return view('frontpage.takeGift', compact('gift'));
    }

    public function sendGift(Request $request, Gift $gift){
        $this->validate($request, [
            'email' => 'required'
        ]);

        $email = $request->input('email');
        $name = $request->input('name');
        $subscribe = $request->has('subscribe');

        Mail::to($email)->send(new SendGift($gift, $name));

        if($subscribe){
            // Add user to newsletter
            $key = env('MAIL_CHIMP_KEY');
            $list_id = env('MAIL_CHIMP_LIST_ID');
            $url = "https://us10.api.mailchimp.com/3.0/lists/$list_id/members/";

            error_log("KEY: " . $key);

            $httpHeader = array(
                'Authorization: apikey '. $key,
                'Content-Type: application/json'
            );

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                "email_address" => $email,
                "status" => "subscribed",
                "merge_fields" => [
                    'FNAME' => $name
                ]
            ]));

            $responseContent = curl_exec($ch);

            curl_close($ch);
        }

        return redirect()->route('frontpage.home');
    }
}
