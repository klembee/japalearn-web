<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class WordType extends Model
{
    protected $table = 'word_types';
    protected $fillable = ['name'];
}
