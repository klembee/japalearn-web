<?php


namespace App\CronTasks;


use App\Helpers\AppointmentHelper;
use App\Models\Appointment;
use Carbon\Carbon;

class CancelUnconfirmedAppointments
{
    /**
     * Cancel the appointments that have not been confirmed by the
     * teacher if it has been three days of more since creation
     */
    public function __invoke()
    {
        $appointmentsToCancel = Appointment::query()
            ->where('date', '>=', Carbon::now())
            ->where('confirmed', false)
            ->where('canceled', false)
            ->where('created_at', '<=', Carbon::now()->subDays(3))->get();

        foreach ($appointmentsToCancel as $appointment){
            AppointmentHelper::refuse($appointment);
        }
    }
}
