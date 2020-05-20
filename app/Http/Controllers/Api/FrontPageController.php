<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Mail\ContactUs;
use App\Models\BlogPost;
use App\Models\GrammarLearningPathItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FrontPageController extends Controller
{
    public function latestArticles(Request $request){
        return response()->json([
            'success' => true,
            'articles' => BlogPost::query()->orderBy('created_at', 'desc')->limit(3)->get()
        ]);
    }

    public function randomGrammarLessons(Request $request){
        return response()->json([
            'success' => true,
            'items' => GrammarLearningPathItem::query()->get()->random(3)
        ]);
    }

    public function contactUs(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $message = $request->input('message');

        // Send email
        Mail::send(new ContactUs($name, $email, $message));

//        $request->session()->flash('message', 'We will get back to you shortly !');

        return redirect()->back();
    }
}