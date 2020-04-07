<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

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
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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


    /**
     * Get the role of the user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(){
        return $this->belongsTo(Role::class);
    }
}
