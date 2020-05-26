<?php


namespace App\Policies;


use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    public function confirm(User $user, Appointment $appointment){
        return $user->info->information->id == $appointment->teacher_info_id;
    }
}
