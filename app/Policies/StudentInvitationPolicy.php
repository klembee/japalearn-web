<?php


namespace App\Policies;


use App\Models\StudentInvitation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StudentInvitationPolicy
{
    public static $NOT_STUDENT_CODE = 1;
    public static $ALREADY_STUDENT_CODE = 2;

    public function generate(User $user){
        return $user->isTeacher();
    }

    public function joinTeacher(User $user, StudentInvitation $invitation){
        if(!$user->isStudent()){
            return Response::deny(__('Your are not a student'), StudentInvitationPolicy::$NOT_STUDENT_CODE);
        }else{
            $userAlreadyStudentOfTeacher = $invitation->teacher->students->contains($user);
            if($userAlreadyStudentOfTeacher){
                return Response::deny(__('You are already a student of this teacher'), StudentInvitationPolicy::$ALREADY_STUDENT_CODE);
            }else{
                return Response::allow();
            }
        }
    }
}
