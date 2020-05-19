<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

class BlogController extends Controller
{

    /**
     * Displays the list of blog post to the admins
     * @param Request $request
     */
    public function index(Request $request){
        return view('app.admin.blog.index');
    }

    /**
     * Allow an admin to create a new blog post
     * @param Request $request
     */
    public function create(Request $request){
        return view('app.admin.blog.create');
    }

}
