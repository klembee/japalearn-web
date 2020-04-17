<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

/**
 * Controller for the tasks relating the account like settings.
 * Class AccountController
 * @package App\Http\Controllers
 */
class AccountController extends Controller
{

    /**
     * Show a form allowing the user to modify its profile information
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile(Request $request){
        return view('app.account.settings.profile');
    }


    /**
     * Save the user profile after submitting the form
     * @param Request $request
     */
    public function updateProfile(Request $request){
        return "";
    }

    public function learning(Request $request){
        return view('app.account.settings.learning');
    }

    public function payment(Request $request){
        return view('app.account.settings.payment');
    }
}
