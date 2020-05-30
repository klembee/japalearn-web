<?php


namespace App\Policies;


use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    public function confirm(User $user, Appointment $appointment){
        return $user->info->id == $appointment->teacher_info_id;
    }

    public function rate(User $user, Appointment $appointment){
        return $user->info->id == $appointment->student_info_id;
    }
}
