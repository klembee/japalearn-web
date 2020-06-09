<?php


namespace App\Helpers;


use Illuminate\Http\Request;

class SubscriptionHelper
{
    public static function isSubscribed(Request $request){
        if(!$request->user()){
            return false;
        }

        if (!$request->user()->subscribed('default')) {
            $request->session()->flash('error', 'You have to subscribe to access this content');
            return false;
        }

        return true;
    }
}
