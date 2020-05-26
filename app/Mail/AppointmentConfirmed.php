<?php


namespace App\Mail;


use App\Models\Appointment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $teacher;

    public function __construct(User $teacher, Appointment $appointment)
    {
        $this->teacher = $teacher;
        $this->appointment = $appointment;
    }

    public function build(){
        return $this->subject('Video lesson confirmed')
            ->from('hello@japalearn.com')
            ->markdown('emails.appointmentConfirmed');
    }
}
