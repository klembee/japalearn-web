<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Model representing a single entry in the
 * email list table
 * Class EmailListItem
 * @package App\Models
 */
class EmailListItem extends Model
{
    protected $table = "email_list";

    protected $fillable = ['name', 'japanese_level', 'email'];
}
