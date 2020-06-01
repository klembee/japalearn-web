<?php


namespace App\CronTasks;

use App\Helpers\VideoConferenceHelper;
use App\Models\Appointment;
use App\Models\Meeting;
use Carbon\Carbon;

/**
 * Checks if a meeting have to be started or stopped
 * Class StartAndStopAWSMeetings
 * @package App\CronTasks
 */
class StartAndStopAWSMeetings
{
    public function __invoke()
    {
        // Create a meeting for all the appointments starting in less than 15 minutes
//        $nowIn15Minutes = Carbon::now()->addMinutes(15);
//
//        $appointments = Appointment::query()
//            ->where('confirmed', true)
//            ->where('canceled', false)
//            ->where('date', '<=', $nowIn15Minutes)
//            ->where('date', '>', Carbon::now())
//            ->whereDoesntHave('meeting')->get();
//
//        foreach ($appointments as $appointment){
//            // Create a new meeting
//            VideoConferenceHelper::createMeeting($appointment);
//        }

        // Stop the meetings that lasted 1 hour after the appointment end

        if(env('APP_ENV') == 'production'){
            $meetings = Meeting::all();
            foreach ($meetings as $meeting){
                $appointment = $meeting->appointment;
                $meetingEnd = $appointment->date->addMinutes($appointment->duration_minute)->addHour();
                error_log($meetingEnd);
                if(Carbon::now()->greaterThan($meetingEnd)){
                    VideoConferenceHelper::stopMeeting($meeting);
                }
            }
        }




    }
}
