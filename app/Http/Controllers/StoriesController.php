<?php


namespace App\Http\Controllers;


use App\Helpers\SubscriptionHelper;
use App\Models\Author;
use App\Models\Story;
use Illuminate\Http\Request;

class StoriesController extends Controller
{
    /**
     * Show the stories and allow an admin to edit and create them
     * @param Request $request
     * @return string
     */
    public function indexAdmin(Request $request){
        $stories = Story::all();
        $authors = Author::all();

        return view('app.admin.stories.index', compact('stories', 'authors'));
    }

    /**
     * Shows a form allowing an admin to create a story
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request){
        return view('app.admin.stories.create');
    }

    /**
     * Allow an admin to edit a story
     * @param Request $request
     * @param Story $story
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, Story $story){
//        $story = $story->load('translations');
        $story = $story->load('vocab');

        return view('app.admin.stories.edit', compact('story'));
    }

    /**
     * Allow an admin to delete a story
     * @param Request $request
     * @param Story $story
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Request $request, Story $story){
        $story->delete();
        return redirect()->route('learning_path.stories.index');
    }


    /**
     * Allow anybody to read a story
     * @param Request $request
     * @param Story $story
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function read(Request $request, Story $story){
        if($story->subscriber_only){
            if(!SubscriptionHelper::isSubscribed($request)){
                // This user is not a paying customer...
                return redirect()->route('account.subscription.index');
            }
        }


        $markdownParser = new \Parsedown();
        $parsedContent = $markdownParser->text($story->content);

        $parsedTranslation = null;

        if($story->translated_content) {
            $parsedTranslation = $markdownParser->text($story->translated_content);
        }

        $story = $story->load('vocab');

        return view('app.stories.read', compact('story', 'parsedContent', $parsedTranslation));
    }
}
