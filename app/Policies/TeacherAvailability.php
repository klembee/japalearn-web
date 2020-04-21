<?php


namespace App\Policies;


use App\Models\User;

class TeacherAvailability
{
    public function canFetchAvailabilitiesOf(User $loggedInUser, User $teacher){
        return true;
    }

    /**
     * Only teachers can update their availabilities
     * @param User $user
     * @return bool
     */
    public function update(User $user){
        return $user->isTeacher();
    }
}
