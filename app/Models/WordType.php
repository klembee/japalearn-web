<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class WordType extends Model
{
    protected $table = 'word_types';
    protected $fillable = ['name'];

    public static function radical(){
        return WordType::query()->where('name', 'radical')->firstOrFail();
    }

    public static function kanji(){
        return WordType::query()->where('name', 'kanji')->firstOrFail();
    }

    public static function vocabulary(){
        return WordType::query()->where('name', 'vocabulary')->firstOrFail();
    }
}
