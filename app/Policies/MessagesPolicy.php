<?php


namespace App\Policies;


use App\Models\Message;
use App\Models\User;

class MessagesPolicy
{
    public function read(User $user, Message $message){
        return true;//todo
    }

    public function chatWith(User $from, User $to){
        return $from->friends->pluck('id')->intersect($to->id)->count() > 0;
    }
}
