<?php

namespace App\Mail;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentRefused extends Mailable
{
    use Queueable, SerializesModels;



    public $teacher;
    public $lesson;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $teacher, Appointment $lesson)
    {
        $this->teacher = $teacher;
        $this->lesson = $lesson;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('view.name');
    }
}
