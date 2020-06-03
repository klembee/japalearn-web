<?php


namespace App\Http\Controllers\Api;


use App\Helpers\PictureUploaderHelper;
use App\Helpers\Slugger;
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
                'slug' => Slugger::slugify($title)
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

    public function fetchComments(Request $request, BlogPost $post){
        return $post->comments()->orderBy('created_at', 'desc')->where('approved', true)->paginate(10);
    }

    public function leaveComment(Request $request, BlogPost $post){
        $this->validate($request, [
            'name' => 'required',
            'comment' => 'required',
            'recaptchaToken' => 'required'
        ]);

        $name = $request->input('name');
        $comment = $request->input('comment');
        $token = $request->input('recaptchaToken');

        $commentModel = $post->comments()->create([
            'author_email' => "",
            'author_name' => $name,
            'comment' => $comment
        ]);


        $score = $this->verifyRecaptcha($request, $token);
        if($score != null){
            if($score >= 0.7){
                $commentModel->approved = true;
                $commentModel->save();
            }
        }else{
            return response()->json([
                'success' => false
            ]);
        }

        return response()->json([
            'success' => true
        ]);
    }

    private function verifyRecaptcha(Request $request, $token){
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $secret = env('GOOGLE_RECAPTCHA_SECRET');
        $userIp = $request->ip();

        $data = [
            'secret' => $secret,
            'response' => $token,
            'remoteip' => $userIp
        ];

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            return response()->json([
                'success' => false
            ]);
        }
        $result = json_decode($result, true);

        if($result['success'] == 1){
            return $result['score'];
        }else{
            return null;
        }


    }
}
