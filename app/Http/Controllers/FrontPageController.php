<?php


namespace App\Http\Controllers;


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
        return view('frontpage.blog');
    }
}
