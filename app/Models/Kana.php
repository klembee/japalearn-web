<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Kana extends Model
{
    protected $table = "kanas";
    protected $fillable = [
        'kana',
        'romaji',
        'mnemonic'
    ];
}
