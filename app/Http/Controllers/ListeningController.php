<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

class ListeningController extends Controller
{
    public function index(Request $request){
        return view('app.listening.index');
    }
}
