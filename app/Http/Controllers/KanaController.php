<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

class KanaController extends Controller
{
    public function index(Request $request){
        return view('app.kanas.index');
    }
}
