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
        ]);

        $postId = $request->input('post_id');
        $title = $request->input('title');
        $content = $request->input('content');

        if($postId == -1){
            //Create a new post
            $blogArticle = new BlogPost([
                'title' => $title,
                'content' => $content,
                'meta_description' => $request->input('meta_description'),
                'slug' => preg_replace('/[^A-Za-z0-9_\-]/', '', strtolower(str_replace(' ', '-', $title)))
            ]);

            $blogArticle->save();

        }else{
            // Update existing post
            $blogArticle = BlogPost::query()->where('id', $postId)->firstOrFail();
            $blogArticle->fill([
                'title' => $title,
                'content' => $content,
                'meta_description' => $request->input('meta_description')
            ]);
            $blogArticle->save();

        }

        if($request->has('image_data')) {
            $file = PictureUploaderHelper::uploadFile($request->input('image_data'));
            $blogArticle->attachPicture($file);
        }

        return response()->json([
            'success' => true,
            'article' => [
                'slug' => $blogArticle->slug,
            ]
        ]);
    }
}
