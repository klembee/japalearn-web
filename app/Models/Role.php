<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "roles";

    public static function admin(){
        return Role::query()->where('name', 'admin')->first();
    }

    public static function moderator(){
        return Role::query()->where('name', 'moderator')->first();
    }

    public static function student(){
        return Role::query()->where('name', 'student')->first();
    }

    public static function teacher(){
        return Role::query()->where('name', 'teacher')->first();
    }
}
