<?php


namespace App\Http\Controllers;


use App\Models\Kana;
use Illuminate\Http\Request;

class KanaLearningPathController extends Controller
{
    public function index(Request $request){
        $kanas = Kana::all();

        return view('app.admin.kana_learning_path.index', compact('kanas'));
    }
}
