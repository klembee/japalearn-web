<?php


namespace App\Http\Controllers;


use App\Models\Story;
use Illuminate\Http\Request;

class ReadingController extends Controller
{
    public function index(Request $request){
        $stories = Story::query()->paginate(15);

        return view('app.reading.index', compact('stories'));
    }
}
