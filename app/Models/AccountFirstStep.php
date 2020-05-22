<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class AccountFirstStep extends Model
{
    protected $table = "account_first_steps";

    protected $fillable = [
        'step'
    ];
}
