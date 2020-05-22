<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LevelUpNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $itemType;
    public $newLevel;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($itemType, $newLevel)
    {
        $this->itemType = $itemType;
        $this->newLevel = $newLevel;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Level up !')->from('hello@japalearn.com')->markdown('emails.levelUp');
    }
}
