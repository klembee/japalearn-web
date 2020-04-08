<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Vocabulary;
use Illuminate\Http\Request;

class DictionaryController extends Controller
{
    public function query(Request $request){
        $this->validate($request, [
            'query' => 'present'
        ]);

        $searchQuery = $request->input('query');
        $response = Vocabulary::query()->whereHas('meanings', function($query) use($searchQuery){
            $query->where('meaning', "=", "$searchQuery");
        })->with(['meanings', 'pos', 'writings'])->paginate(10);

        return $response;
    }
}
