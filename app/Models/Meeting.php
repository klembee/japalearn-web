<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $table = "meetings";

    protected $fillable = [
        'region',
        'client_request_token'
    ];

    public function users(){
        return $this->hasMany(MeetingUser::class, 'meeting_id');
    }

    public function appointment(){
        return $this->belongsTo(Appointment::class);
    }

    public function getRouteKeyName()
    {
        return "aws_meeting_id";
    }
}
