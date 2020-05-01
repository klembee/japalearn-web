<?php


namespace App\Helpers;


use App\Models\User;
use Aws\Chime\ChimeClient;
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
        error_log(env("AWS_ACCESS_KEY_ID"));
        error_log(env("AWS_SECRET_ACCESS_KEY"));


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
    public static function createMeeting(){
        $chimeClient = VideoConferenceHelper::getClient();

        // Create the meeting
        $meeting = $chimeClient->createMeeting([
            "ClientRequestToken" => Uuid::uuid4(),
            "MediaRegion" => "ca-central-1",
        ]);

        return $meeting['Meeting'];
    }

    public static function getMeeting($meetingId){
        $chimeClient = VideoConferenceHelper::getClient();
        return $chimeClient->getMeeting([
            'MeetingId' => $meetingId
        ])['Meeting'];
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
