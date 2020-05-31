<?php

namespace App\Mail;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAppointmentConfirmationLinkToTeacher extends Mailable
{
    use Queueable, SerializesModels;


    public $student;
    public $appointment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $student, Appointment $appointment)
    {
        $this->student = $student;
        $this->appointment = $appointment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New appointment to confirm')->markdown('emails.toTeacher.appointmentToConfirm');
    }
}
