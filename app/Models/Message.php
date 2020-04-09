<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['message'];

    public function to(){
        return $this->belongsTo(User::class, 'to_id');
    }

    public function from(){
        return $this->belongsTo(User::class, 'from_id');
    }
}
