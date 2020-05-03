<?php


namespace App\Http\Controllers;


use App\Models\EmailListItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EmailListController extends Controller
{
    public function add(Request $request){
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $listItem = new EmailListItem($request->all());
        $listItem->save();

        return redirect()->to("https://japalearn.ca?subscribed=1");
    }
}
