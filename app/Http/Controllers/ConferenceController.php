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

    public function join(Request $request, Meeting $meeting)
    {
        $user = $request->user();

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
            $request->session()->flash('error', 'This meeting has ended');
            return redirect()->route('dashboard');
        }
    }
}
