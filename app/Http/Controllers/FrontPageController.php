<?php


namespace App\Http\Controllers;


use App\Models\BlogPost;
use Illuminate\Http\Request;

class FrontPageController extends Controller
{
    public function home(Request $request){
        return view('frontpage.home');
    }

    public function grammar(Request $request){
        return view('frontpage.grammar');
    }

    public function stories(Request $request){
        return view('frontpage.stories');
    }

    public function blog(Request $request){
        $posts = BlogPost::query()->paginate(5);

        return view('frontpage.blog', compact('posts'));
    }

    public function viewArticle(Request $request, BlogPost $post){
        return view('frontpage.viewArticle', compact('post'));
    }
}
