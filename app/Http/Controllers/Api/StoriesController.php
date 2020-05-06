<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;

class StoriesController extends Controller
{
    /**
     * Allow an admin to update or create a new story
     * @param Request $request
     */
    public function createUpdate(Request $request){
        $this->validate($request, [
            'story_id' => 'required',
            'title' => "required",
            'content' => "required",
            'keywords' => "present"
        ]);

        $storyId = $request->input('story_id');

        if($storyId == -1){
            // Create a new story
            $story = new Story([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'keywords' => $request->input('keywords')
            ]);
            $story->save();
        }else{
            // Update existing one
            $story = Story::query()->where('id', $storyId)->firstOrFail();
            $story->fill([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'keywords' => $request->input('keywords')
            ]);
            $story->save();
        }

        return response()->json([
            'success' => true,
            'story_url' => route('stories.read', $story)
        ]);

    }
}
