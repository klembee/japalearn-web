<?php


namespace App\Listeners;


use App\Events\KanjiLeveledUp;
use App\Mail\LevelUpNotification;
use Illuminate\Support\Facades\Mail;

class SendKanjiLevelUpNotification
{
    public function handle(KanjiLeveledUp $event){
        // Send the email to the user
        Mail::to($event->user->email)->send(new LevelUpNotification('kanjis', $event->newLevel));
    }
}
