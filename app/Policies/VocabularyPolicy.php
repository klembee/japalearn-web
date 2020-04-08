<?php


namespace App\Policies;


use App\Models\User;

class VocabularyPolicy
{
    public function add(User $user){
        return $user->isStudent();
    }
}
