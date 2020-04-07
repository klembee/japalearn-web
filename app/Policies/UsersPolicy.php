<?php


namespace App\Policies;


use App\Models\User;

class UsersPolicy
{
    public function before($user, $ability){
        if(!$user->isAdmin()){
            return false;
        }
        return true;
    }

    /**
     * Check if the current user can list the users
     * @param User $user
     * @return bool
     */
    public function list(User $user){
        return $user->isAdmin();
    }

    /**
     * Check if the current user can create a user
     * @param User $user
     */
    public function create(User $user){

    }
}
