<?php


namespace App\Http\Controllers;


use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Controller for the tasks relating the account like settings.
 * Class AccountController
 * @package App\Http\Controllers
 */
class AccountController extends Controller
{

    /**
     * Shows a form allowing a user to update its preferences
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function preferences(Request $request){
        return view('app.account.settings.preferences');
    }

    /**
     * Update the preferences of the user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updatePreferences(Request $request){
        $this->validate($request, [
            'locale' => 'required'
        ]);

        error_log(print_r($request->all(), true));

        $user = $request->user();
        $user->locale = $request->input('locale');
        $user->save();


        return redirect()->back();
    }

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
        if($request->has('password') and strlen($request->input('password')) > 0){
            // Check that the password and password confirmation are the same
            $password = $request->input('password');
            $password_conf = $request->input('password_conf');

            if($password == $password_conf){
                $user->password = Hash::make($password);
                $user->save();
            }
        }

        // If the user have uploaded a profile picture
        if($request->has('picture')){
            $picture_base64 = $request->input('picture');

            //Convert to file
            //todo: Make this into a helper function if used a lot
            $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $picture_base64));

            $tmpFilePath = sys_get_temp_dir() . "/" . Str::uuid()->toString();
            file_put_contents($tmpFilePath, $fileData);

            $tmpFile = new File($tmpFilePath);
            $file = new UploadedFile(
                $tmpFile->getPathname(),
                $tmpFile->getFilename(),
                $tmpFile->getMimeType(),
                0,
                true
            );

            $user->setProfileImage($file);
        }

        return redirect()->route('account.profile.index');
    }

    public function learning(Request $request){
        return view('app.account.settings.learning');
    }

    public function payment(Request $request){
        $user = $request->user();
        $paymentMethods = $user->paymentMethods()->toarray();

        $stripeIntent = $request->user()->createSetupIntent()->client_secret;
        return view('app.account.settings.payment', compact('paymentMethods', 'stripeIntent'));
    }
}
