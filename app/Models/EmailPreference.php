<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class EmailPreference extends Model
{
    protected $table = "email_preferences";

    protected $fillable = [
        'code',
        'description'
    ];
}
