<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KanaLearningPathController extends Controller
{
    public function updateLevel(Request $request){
        $user = $request->user();
        //todo: Verify that the user waited ennough time to update this level

        $this->validate($request, [
            'good' => "present|array",
            'wrong' => 'present|array'
        ]);

        foreach($request->input('good') as $good){

        }

        foreach($request->input('bad') as $bad){

        }
    }
}
