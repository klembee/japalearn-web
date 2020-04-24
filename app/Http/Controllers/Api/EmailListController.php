<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\EmailListItem;
use Illuminate\Http\Request;

/**
 * Controller that allows to add people information in the
 * email list table
 * Class EmailListController
 * @package App\Http\Controllers\Api
 */
class EmailListController extends Controller
{
    public function add(Request $request){
        $this->validate($request, [
            'email' => 'required'
        ]);

        try {
            $emailList = new EmailListItem($request->all());
            $emailList->save();
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }
}
