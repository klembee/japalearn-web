<?php


namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Represent a lesson appointment between a
 * student and a teacher in the database
 * Class Appointment
 * @package App\Models
 */
class Appointment extends Model
{
    protected $table = "appointments";
    protected $appends = [
        'ready_to_join'
    ];

    protected $fillable = [
        'date',
        'duration_minute',
        'cost_total',
        'payment_stripe_id',
    ];

    protected $dates = [
        'date'
    ];

    public function studentInfo(){
        return $this->belongsTo(StudentInfo::class,'student_info_id');
    }

    public function teacherInfo(){
        return $this->belongsTo(TeacherInfo::class, 'teacher_info_id');
    }

    /**
     * Check if the lesson is joinable.
     * The users can join the lesson 15 minutes before it starts
     * @return bool
     */
    public function getReadyToJoinAttribute(){
        $now = Carbon::now();
        $dateReady = $this->date->subMinutes(15);

        return $now->greaterThan($dateReady);
    }
}
