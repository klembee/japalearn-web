<?php

namespace App\Mail;

use App\Models\Gift;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendGift extends Mailable
{
    use Queueable, SerializesModels;

    public $gift;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Gift $gift, $name)
    {
        $this->gift = $gift;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this
            ->from('hello@japalearn.com')
            ->subject('Gift from JapaLearn')
            ->markdown('emails.sendGift');

        return $email;
    }
}
