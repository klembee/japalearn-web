<?php


namespace App\Policies;


use App\Models\Meeting;
use App\Models\User;

class MeetingPolicy
{
    public function join(User $user, Meeting $meeting){
        return $meeting->users()->where('user_id', $user->id)->count() > 0;
    }
}
