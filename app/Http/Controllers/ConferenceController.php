<?php


namespace App\Http\Controllers;


use App\Helpers\VideoConferenceHelper;
use App\Models\Appointment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{
    public function index(Request $request){
        $user = $request->user();

        $meeting = VideoConferenceHelper::createMeeting(
            Appointment::query()->first()
            );
        $attendee = VideoConferenceHelper::joinMeeting($meeting['MeetingId'], $user);


        error_log(print_r($meeting, true));

        return view('app.conference.index', compact('meeting', 'attendee'));
    }

    public function join(Request $request, $meetingId){
        $meeting = VideoConferenceHelper::getMeeting($meetingId);
        $attendee = VideoConferenceHelper::joinMeeting($meetingId, $request->user());

        return view('app.conference.index', compact('meeting', 'attendee'));
    }
}
