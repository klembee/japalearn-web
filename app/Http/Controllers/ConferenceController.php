<?php


namespace App\Http\Controllers;


use App\Helpers\VideoConferenceHelper;
use App\Models\Appointment;
use App\Models\Meeting;
use App\Models\Role;
use App\Models\User;
use Aws\Chime\Exception\ChimeException;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{
    public function index(Request $request){
        $user = $request->user();

        $awsMeeting = VideoConferenceHelper::createMeeting(
            Appointment::query()->first()
            );

        $awsAttendee = VideoConferenceHelper::joinMeeting($awsMeeting['MeetingId'], $user);

        $meeting = Meeting::query()->where('aws_meeting_id', $awsMeeting['MeetingId'])->firstOrFail();
        $people = $meeting->users->pluck('user_id');
        $messages = $meeting->users()->where('user_id', '!=', $user->id)->firstOrFail()->user->messages()->load(['from', 'to'])
            ->whereIn('from_id', $people)
            ->whereIn('to_id', $people);

        $otherId = $meeting->users()->where('user_id', '!=', $user->id)->firstOrFail()->user->id;

        return view('app.conference.index', compact('awsMeeting', 'awsAttendee', 'messages', 'otherId'));
    }

    public function join(Request $request, Appointment $appointment)
    {
        $user = $request->user();
        $this->authorize('join', $appointment);

        // Check that the meeting can be joined
        $start = $appointment->date->subMinutes(15);
        $end = $appointment->date->addMinutes($appointment->duration_minute);
        if(!Carbon::now()->between($start, $end)){
            $request->session()->flash('error', 'This meeting is not joinable at this time');
            return redirect()->route('dashboard');
        }

        $meeting = $appointment->meeting;

        //The first person that enters the meeting, creates it
        if(!$meeting || VideoConferenceHelper::meetingDoesntExists($meeting)){
            // Create the meeting
            Meeting::query()->where('appointment_id', $appointment->id)->delete();
            $meeting = VideoConferenceHelper::createMeeting($appointment);
        }

        try{
            $awsMeeting = VideoConferenceHelper::getMeeting($meeting->aws_meeting_id);
            $awsAttendee = VideoConferenceHelper::getAttendee($user, $meeting);

            $people = $meeting->users->pluck('user_id');
            $messages = $meeting->users()->where('user_id', '!=', $user->id)->firstOrFail()->user->messages()->load(['from', 'to'])
                ->whereIn('from_id', $people)
                ->whereIn('to_id', $people);
            $otherId = $meeting->users()->where('user_id', '!=', $user->id)->firstOrFail()->user->id;

            return view('app.conference.index', compact('awsMeeting', 'awsAttendee', 'messages', 'otherId'));

        }catch(ChimeException $e){
            error_log($e->getMessage());
            $request->session()->flash('error', 'This meeting has ended');
            return redirect()->route('dashboard');
        }
    }
}
