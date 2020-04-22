<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    /**
     * Allows a student to add a payment method to his/her account
     * @param Request $request
     * @return string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addPaymentMethod(Request $request){
        $this->validate($request, [
            'payment' => 'required'
        ]);

        $user = $request->user();
        $paymentMethod = $request->input('payment');

        if(!$user->stripe_id){
            $user->createAsStripeCustomer();
        }

        $user->addPaymentMethod($paymentMethod);

        if(!$user->hasDefaultPaymentMethod()) {
            // Add the newly added payment method as default
            $user->updateDefaultPaymentMethod($paymentMethod);
        }

        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }

    /**
     * Allows a student to delete a payment method
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function deletePaymentMethod(Request $request){
        error_log(print_r($request->all, true));
        $this->validate($request, [
            'payment_id' => 'required'
        ]);

        $paymentMethod = $request->user()->findPaymentMethod($request->input('payment_id'));
        if($paymentMethod) {
            $paymentMethod->delete();
        }else{
            return response()->json([
                'success' => false,
                'message' => "Payment method does not exist"
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }
}
