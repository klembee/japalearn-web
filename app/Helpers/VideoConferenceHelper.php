<?php


namespace App\Helpers;


use App\Mail\AppointmentStartsIn15Minutes;
use App\Models\Appointment;
use App\Models\Meeting;
use App\Models\MeetingUser;
use App\Models\User;
use Aws\Chime\ChimeClient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Ramsey\Uuid\Uuid;

/**
 * Helper class to make it easier to create
 * video conference between students and teachers
 * Class VideoConferenceHelper
 * @package App\Helpers
 */
class VideoConferenceHelper
{
    /**
     * Get an instance of the chime client
     * @return ChimeClient
     */
    private static function getClient(){
        return new ChimeClient([
            "region" => "ca-central-1",
            "version" => "2018-05-01",
            "credentials" => [
                'key' => env("AWS_ACCESS_KEY_ID"),
                'secret' => env("AWS_SECRET_ACCESS_KEY")
            ],
        ]);
    }

    /**
     * Create a meeting between two users
     * @param User $user1
     * @param User $user2
     * @return \Aws\Result
     */
    public static function createMeeting(Appointment $appointment){
        $user1 = $appointment->teacherInfo->user;
        $user2 = $appointment->studentInfo->user;

        return DB::transaction(function() use($user1, $user2, $appointment){
            $chimeClient = VideoConferenceHelper::getClient();

            $meeting = new Meeting([
                'region' => "ca-central-1",
                "client_request_token" => Uuid::uuid4()
            ]);
            $meeting->appointment_id = $appointment->id;
            $meeting->save();

            // Create the meeting
            $awsMeeting = $chimeClient->createMeeting([
                'ExternalMeetingId' => "meeting_" . $meeting->id,
                "ClientRequestToken" => $meeting->client_request_token,
                "MediaRegion" => $meeting->region,
            ]);

            $meeting->aws_meeting_id = $awsMeeting['Meeting']['MeetingId'];
            $meeting->save();

            // Add the users to the meeting
            $awsAttendee1 = $chimeClient->createAttendee([
                "MeetingId" => $meeting->aws_meeting_id,
                "ExternalUserId" => "user_" . $user1->id
            ]);

            $awsAttendee2 = $chimeClient->createAttendee([
                "MeetingId" => $meeting->aws_meeting_id,
                "ExternalUserId" => "user_" . $user2->id
            ]);

            $meetingUser1 = new MeetingUser([
                'aws_attendee_id' =>  $awsAttendee1['Attendee']['AttendeeId'],
                'token' => $awsAttendee1['Attendee']['JoinToken']
            ]);
            $meetingUser1->meeting_id = $meeting->id;
            $meetingUser1->user_id = $user1->id;
            $meetingUser1->save();

            $meetingUser2 = new MeetingUser([
                'aws_attendee_id' =>  $awsAttendee2['Attendee']['AttendeeId'],
                'token' => $awsAttendee2['Attendee']['JoinToken']
            ]);
            $meetingUser2->meeting_id = $meeting->id;
            $meetingUser2->user_id = $user2->id;
            $meetingUser2->save();

            // Send emails to the teacher and student with link to join the meeting

            Mail::to($user1->email)->send(new AppointmentStartsIn15Minutes($appointment, $meeting));
            Mail::to($user2->email)->send(new AppointmentStartsIn15Minutes($appointment, $meeting));

            return $awsMeeting['Meeting'];
        });
    }

    /**
     * Stop the specified meeting
     * @param $meetingId
     * @throws \Exception
     */
    public static function stopMeeting(Meeting $meeting){
        $chimeClient = VideoConferenceHelper::getClient();
        $chimeClient->deleteMeeting([
            'MeetingId' => $meeting->aws_meeting_id
        ]);

        $meeting->delete();
    }

    public static function getMeeting($meetingId){
        $chimeClient = VideoConferenceHelper::getClient();
        return $chimeClient->getMeeting([
            'MeetingId' => $meetingId
        ])['Meeting'];
    }

    public static function getAttendee(User $user, Meeting $meeting){
        $chimeClient = VideoConferenceHelper::getClient();

        $attendeeId = $meeting->users()->where('user_id', $user->id)->firstOrFail()->aws_attendee_id;

        return $chimeClient->getAttendee([
            'AttendeeId' => $attendeeId,
            'MeetingId' => $meeting->aws_meeting_id
        ])['Attendee'];
    }

    public static function joinMeeting($meeting, User $user){
        $chimeClient = VideoConferenceHelper::getClient();
        $attendee = $chimeClient->createAttendee([
                "MeetingId" => $meeting,
                "ExternalUserId" => "user_" . $user->id
            ]);

        return $attendee['Attendee'];
    }
}
