<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Stripe\Exception\OAuth\InvalidGrantException;
use Stripe\OAuth;
use Stripe\Stripe;

class StripeController extends Controller
{
    /**
     * After the teacher created his/her stripe account, redirected here
     * @param Request $request
     * @return array|string|null
     * @throws \Illuminate\Validation\ValidationException
     */
    public function teacherSetupRedirect(Request $request){
        $this->validate($request, [
            'code' => 'required',
            'state' => 'required'
        ]);

        $user = $request->user();
        if($user->info->stripe_state == $request->get('state')){
            $code = $request->query('code');

            Stripe::setApiKey(env('STRIPE_SECRET'));
            try {
                $stripeResponse = OAuth::token([
                    'grant_type' => 'authorization_code',
                    'code' => $code
                ]);
            }catch(InvalidGrantException $e){
                $request->session()->flash('error', 'Invalid authorization code. Please try again');
                return redirect()->route('account.getpaid.index');
            }catch(\Exception $e){
                $request->session()->flash('error', 'An error occurred. Please try again later.');
                return redirect()->route('account.getpaid.index');
            }

            $connectedAccountId = $stripeResponse->stripe_user_id;
            $user->info->stripe_account_id = $connectedAccountId;
            $user->info->save();
        }else{
            $request->session()->flash('error', 'The state does not match.');
        }

        return redirect()->route('dashboard');
    }
}
