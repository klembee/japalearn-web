<?php


namespace App\Helpers;


use Illuminate\Http\Request;

class SubscriptionHelper
{
    public static function isSubscribed(Request $request){
        if(!$request->user() || !$request->user()->subscribed('default')){
            return false;
        }

        return true;
    }
}
