<?php


namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TeacherAvailability extends Model
{
    protected $table = "teacher_availabilities";

    /**
     * Get the hours without the seconds
     * @param $hour
     * @return string
     */
    public function getHourAttribute($hour){
        return Carbon::createFromFormat("H:i:s", $hour)->format('H:i');
    }
}
