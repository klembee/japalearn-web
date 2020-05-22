<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OneWeekSubscriptionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $amount;
    public $date;
    public $durationNumber;
    public $durationType;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($amount, $date, $durationNumber, $durationType)
    {
        $this->amount = $amount;
        $this->date = $date;
        $this->durationNumber = $durationNumber;
        $this->durationType = $durationType;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Subscription renewing soon')->from('hello@japalearn.com')->markdown('emails.oneWeekLeftSubscription');
    }
}
