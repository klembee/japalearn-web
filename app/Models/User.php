<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'created_at',
        'modified_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'firstname',
        'lastname'
    ];

    public function hasRole($role){
        return strtolower($this->role->name) === strtolower($role);
    }

    /**
     * Check if the user has the admin role
     * @return bool true if the user is admin, false otherwise
     */
    public function isAdmin(){
        return $this->role_id === Role::admin()->id;
    }

    /**
     * Check if the user has the teacher role
     * @return bool true if the user is teacher, false otherwise
     */
    public function isTeacher(){
        return $this->role_id === Role::teacher()->id;
    }

    /**
     * Check if the user has the student role
     * @return bool true if the user is student, false otherwise
     */
    public function isStudent(){
        return $this->role_id === Role::student()->id;
    }

    /**
     * Check if the user has the moderator role
     * @return bool true if the user is moderator, false otherwise
     */
    public function isModerator(){
        return $this->role_id === Role::moderator()->id;
    }

    public function getFirstnameAttribute(){
        return explode(' ', $this->name)[0];
    }

    public function getLastnameAttribute(){
        $lastname = explode(' ', $this->name);
        if(count($lastname) > 1){
            return implode(' ', array_splice($lastname, 1));
        }else{
            return "";
        }
    }

    /**
     * Function that makes it easier to upload a profile picture
     * for the current user
     * @param $image
     */
    public function setProfileImage(UploadedFile $image){
        $savedFile = $image->store('public/avatars');

        //todo: Resize to a specific size to reduce file space
        // Remove the "/public/" part before save in database
        $path = substr($savedFile, strpos($savedFile, "/") + 1);

        $this->picture_path = $path;
        $this->save();
    }

    public function messages(){
        return Message::query()->whereHas('to', function($query){
            $query->where('id', $this->id);
        })->orWhereHas('from', function($query){
            $query->where('id', $this->id);
        })->get();
    }

    /**
     * Get the list of messages sent from this user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messagesSent(){
        return $this->hasMany(Message::class, 'from_id');
    }

    /**
     * Get the list of messages received to this user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messagesReceived(){
        return $this->hasMany(Message::class, 'to_id');
    }

    public function info(){
        return $this->hasOne(UserInformation::class);
    }


    public function vocabulary(){
        return $this->belongsToMany(
            Vocabulary::class,
            'student_vocabulary',
            'student_id',
            'vocabulary_id')->withPivot('level', 'last_studied');
    }

    public function scopeVocabulary($query){
        if($this->isStudent()){
            return $query->with('vocabulary');
        }else{
            return $query;
        }
    }

    /**
     * Get the users of this user
     * ** Note: If the user is not a student, this returns a new query !
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teachers(){
        if(!$this->isStudent()){
            error_log("Trying to access teachers of non student");
            return $this->newQuery();
        }

        return $this->belongsToMany(
            User::class,
            'student_teacher',
            "student_id",
            "teacher_id"
        );
    }

    //todo: Do scope teachers and scope students

    /**
     * Get the students of this user
     * ** Note: If the user is not a teacher, this returns a new query !
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students(){
        if(!$this->isTeacher()){
            error_log("Trying to access students of non teacher");
            return $this->newQuery();
        }

        return $this->belongsToMany(
            User::class,
            'student_teacher',
            "teacher_id",
            "student_id"
        );
    }

    /**
     * Get the list of friends of this user
     */
    public function friends(){
        return $this->belongsToMany(
            User::class,
            'user_friend',
            'user_id',
            'friend_id');
    }


    /**
     * Get the role of the user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(){
        return $this->belongsTo(Role::class);
    }
}
