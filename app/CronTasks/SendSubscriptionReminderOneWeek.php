<?php


namespace App\CronTasks;

use App\Mail\OneWeekSubscriptionNotification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Subscription;

/**
 * Check all the subscriptions and send an email to the users telling them that
 * their subscription will renew in one week.
 * Class SendSubscriptionReminderOneWeek
 * @package App\CronTasks
 */
class SendSubscriptionReminderOneWeek
{
    public function __invoke(){
        foreach (Subscription::all() as $sub){
            $subscription = \Stripe\Subscription::retrieve($sub->stripe_id);
            $periodEnd = Carbon::createFromTimestamp($subscription->current_period_end);
            $now = Carbon::now();
            $daysUntilEnd = $periodEnd->diffInDays($now);

            // Check that the subscription was not already canceled
            if(!$subscription->cancel_at_period_end) {
                if ($daysUntilEnd <= 7) {
                    // Send email
                    $amount = $subscription->plan->amount / 100;
                    $duration_number = $subscription->plan->interval_count;
                    $duration_type = $subscription->plan->interval;
                    $date = $periodEnd->format("Y-m-d");

                    $userEmail = $sub->user->email;
                    Mail::to($userEmail)->send(new OneWeekSubscriptionNotification($amount, $date, $duration_number, $duration_type));
                }
            }

        }
    }
}
