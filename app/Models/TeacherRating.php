<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TeacherRating extends Model
{
    protected $table = "teacher_ratings";

    public function teacherInfo(){
        return $this->belongsTo(TeacherInfo::class, 'teacher_info_id');
    }
}
