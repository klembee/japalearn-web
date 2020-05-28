<?php

namespace App\Mail;

use App\Models\Appointment;
use App\Models\Meeting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentStartsIn15Minutes extends Mailable
{
    use Queueable, SerializesModels;


    public $appointment;
    public $meeting;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Appointment $appointment, Meeting $meeting)
    {
        $this->appointment = $appointment;
        $this->meeting = $meeting;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Appointment in 15 minutes")->markdown('emails.appointmentSoon');
    }
}
