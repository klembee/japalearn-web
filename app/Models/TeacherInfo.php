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
    protected $appends = [
        'average_rating'
    ];

    public function user(){
        return $this->morphOne(User::class, 'information');
    }

    public function appointments(){
        return $this->hasMany(Appointment::class, 'teacher_info_id');
    }

    public function ratings(){
        return $this->hasMany(TeacherRating::class, 'teacher_info_id');
    }

    public function getStripeCreateAccountUrl(){
        $this->newStripeState();
        $client_id = env('STRIPE_ACCOUNT_CLIENT_ID');
        $state = $this->stripe_state;
        $user = $this->user;

        return "https://connect.stripe.com/express/oauth/authorize?client_id=$client_id&state=$state&suggested_capabilities[]=transfers&stripe_user[email]=$user->email&stripe_user[country]=CA&stripe_user[first_name]=$user->firstname&stripe_user[last_name]=$user->lastname&stripe_user[currency]=cad";
    }

    public function getAverageRatingAttribute(){
        return round($this->ratings()->average('rating'));
    }

    public function newStripeState(){
        $this->stripe_state = bin2hex(random_bytes(25));
        $this->save();
    }

}
