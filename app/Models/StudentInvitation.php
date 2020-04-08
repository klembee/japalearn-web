<?php


namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StudentInvitation extends Model
{
    protected $table = "student_invitation";
    protected $dates = ['created_at', 'updated_at'];

    private $NUMBER_OF_DAYS_VALID = 7;

    public function teacher(){
        return $this->belongsTo(User::class, "teacher_id");
    }

    public function isValid(){
        // The code is valid for seven days
        return $this->created_at->diffInDays(Carbon::now()) <= $this->NUMBER_OF_DAYS_VALID;
    }
}
