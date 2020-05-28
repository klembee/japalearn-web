<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MeetingUser extends Model
{
    protected $table = "meeting_user";

    protected $fillable = [
        'aws_attendee_id',
        'token'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function meeting(){
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }
}
