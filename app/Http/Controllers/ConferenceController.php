<?php


namespace App\Http\Controllers;


use App\Helpers\VideoConferenceHelper;
use App\Models\Appointment;
use App\Models\Meeting;
use App\Models\Role;
use App\Models\User;
use Aws\Chime\Exception\ChimeException;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{
    public function index(Request $request, Meeting $meeting){
        $user = $request->user();

        $awsMeeting = VideoConferenceHelper::createMeeting(
            Appointment::query()->first()
            );
        $awsAttendee = VideoConferenceHelper::joinMeeting($meeting['MeetingId'], $user);


        error_log(print_r($meeting, true));

        return view('app.conference.index', compact('awsMeeting', 'awsAttendee'));
    }

    public function join(Request $request, Meeting $meeting)
    {
        $user = $request->user();

        try{
            $awsMeeting = VideoConferenceHelper::getMeeting($meeting->aws_meeting_id);
            $awsAttendee = VideoConferenceHelper::getAttendee($user, $meeting);

            return view('app.conference.index', compact('awsMeeting', 'awsAttendee'));

        }catch(ChimeException $e){
            $request->session()->flash('error', 'This meeting has ended');
            return redirect()->route('dashboard');
        }
    }
}
