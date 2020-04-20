<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

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
        $user = $request->user();

        return view('app.account.settings.profile.profile', compact('user'));
    }


    /**
     * Save the user profile after submitting the form
     * @param Request $request
     */
    public function updateProfile(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255',
            'password_conf' => 'required_with:password'
        ]);

        $user = $request->user();

        // Change the name of the user
        $user->name = $request->input('name');
        $user->save();

        // If the user wants to change its password
        if($request->has('password')){
            // Check that the password and password confirmation are the same
            $password = $request->input('password');
            $password_conf = $request->input('password_conf');

            if($password == $password_conf){
                $user->password = Crypt::encrypt($password);
                $user->save();
            }
        }

        // If the user have uploaded a profile picture
//        error_log(print_r($request->all(), true));

        if($request->hasFile('picture')){
            error_log("Has picture");
            $picture = $request->file('picture');
            $user->setProfileImage($picture);
        }

//        return redirect()->route('account.profile.index');
    }

    public function learning(Request $request){
        return view('app.account.settings.learning');
    }

    public function payment(Request $request){
        return view('app.account.settings.payment');
    }
}
