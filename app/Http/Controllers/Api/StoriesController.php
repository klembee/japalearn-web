<?php


namespace App\Http\Controllers\Api;


use App\Helpers\PictureUploaderHelper;
use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\StoryTranslation;
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

        $file = null;

        if($request->has('image_data')){
            $imageData = $request->input('image_data');
            $file = PictureUploaderHelper::uploadFile($imageData);
        }

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

            // Save the translations
            if($request->has('translations')){
                $story->translations()->delete();

                foreach($request->input('translations') as $translation){
                    $story->translations()->save(new StoryTranslation([
                        'japanese' => $translation['japanese'],
                        'lang' => $translation['lang'] ?: 'en',
                        'translation' => $translation['translation'] ?: ""
                    ]));
                }
            }

            // Add the new phrases as empty translations
            if($request->has('new_phrases')){
                foreach($request->input('new_phrases') as $phrase){
                    $story->translations()->save(new StoryTranslation([
                        'japanese' => $phrase,
                        'lang' => 'en',
                        'translation' => ""
                    ]));
                }
            }
        }

        // If file uploaded, attach it to the story
        if($file){
            $story->setFrontImage($file);
            $story->save();
        }

        return response()->json([
            'success' => true,
            'story_url' => route('stories.read', $story)
        ]);

    }
}