<?php


namespace App\Helpers;


use App\Mail\AppointmentConfirmed;
use App\Mail\AppointmentRefused;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class AppointmentHelper
{
    /**
     * Confirm a lesson appointment. The logged in user must be a teacher,
     * capture the payment and send email to student
     * @param Appointment $lesson
     * @return array
     */
    public static function confirm(Appointment $lesson){
        $lesson->confirmed = true;
        $lesson->save();

        // Capture the payment
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $payment = PaymentIntent::retrieve($lesson->payment_stripe_id);
            $payment->capture();

            // Send email to student
            $teacher = $lesson->teacherInfo->user;
            Mail::to($lesson->studentInfo->user->email)->send(new AppointmentConfirmed($teacher, $lesson));
        }catch (\Exception $e){
            error_log($e->getMessage());

            return [
                'success' => false,
                'message' => "Error while capturing payment"
            ];
        }

        return [
            'success' => true,
            'message' => ""
        ];
    }

    /**
     * Refuses the appointment, cancels the pending payment and send email to student.
     * @param Appointment $lesson
     * @return array
     */
    public static function refuse(Appointment $lesson){

        $lesson->confirmed = true;
        $lesson->canceled = true;
        $lesson->save();

        // Cancel the payment
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $payment = PaymentIntent::retrieve($lesson->payment_stripe_id);
            $payment->cancel([
                'cancellation_reason' => "abandoned"
            ]);

            // Send email to student
            $teacher = $lesson->teacherInfo->user;
            Mail::to($lesson->studentInfo->user->email)->send(new AppointmentRefused($teacher, $lesson));
        }catch (\Exception $e){
            error_log($e->getMessage());

            return [
                'success' => false,
                'message' => "Error while canceling payment"
            ];
        }

        return [
            'success' => true,
            'message' => ""
        ];

    }
}
