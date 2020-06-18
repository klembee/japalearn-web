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

        $items = GrammarLearningPathItem::query()->get();
        $nb = min($items->count(), 3);


        return response()->json([
            'success' => true,
            'items' => $items->random($nb)
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
        Mail::to('info@japalearn.com')->send(new ContactUs($name, $email, $message));



        return redirect()->back();
    }
}
