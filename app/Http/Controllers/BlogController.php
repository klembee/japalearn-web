<?php


namespace App\Http\Controllers;


use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    /**
     * Displays the list of blog post to the admins
     * @param Request $request
     */
    public function index(Request $request){

        $posts = BlogPost::query()->paginate(5);

        return view('app.admin.blog.index', compact('posts'));
    }

    /**
     * Allow an admin to create a new blog post
     * @param Request $request
     */
    public function create(Request $request){
        return view('app.admin.blog.create');
    }

    public function edit(Request $request, BlogPost $post){
        return view('app.admin.blog.create', compact('post'));
    }

}
