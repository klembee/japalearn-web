<?php


namespace App\Events;


use App\Models\User;

class KanjiLeveledUp
{
    public $user;

    public $newLevel;

    public function __construct(User $user, $newLevel)
    {
        $this->user = $user;
        $this->newLevel = $newLevel;
    }

}
