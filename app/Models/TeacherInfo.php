<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Contains information concerning a teacher
 * Class TeacherInfo
 * @package App\Models
 */
class TeacherInfo extends Model
{
    public $table = "teacher_info";

    public function user(){
        return $this->hasOneThrough(User::class, UserInformation::class, 'information_id', 'id', 'id', 'user_id');
    }

    public function appointments(){
        return $this->hasMany(Appointment::class, 'teacher_info_id');
    }

}
