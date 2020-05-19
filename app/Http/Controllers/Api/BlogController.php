<?php


namespace App\Http\Controllers\Api;


use App\Helpers\PictureUploaderHelper;
use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function save(Request $request){
        $this->validate($request, [
            'post_id' => 'required',
            'title' => 'required',
            'content' => 'required',
            'image_data' => 'required'
        ]);

        $postId = $request->input('post_id');
        $title = $request->input('title');
        $content = $request->input('content');

        if($postId == -1){
            //Create a new post
            $blogArticle = new BlogPost([
                'title' => $title,
                'content' => $content
            ]);

            $blogArticle->save();

        }else{
            // Update existing post
            $blogArticle = BlogPost::query()->where('id', $postId)->firstOrFail();
            $blogArticle->fill([
                'title' => $title,
                'content' => $content
            ]);
            $blogArticle->save();

        }

        $file = PictureUploaderHelper::uploadFile($request->input('image_data'));
        $blogArticle->attachPicture($file);

        return response()->json([
            'success' => true,
            'article' => [
                'id' => $blogArticle->id,
            ]
        ]);
    }
}
