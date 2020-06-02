<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class StoryVocab extends Model
{
    protected $table = "story_vocab";

    protected $fillable = [
        'word',
        'reading',
        'meaning'
    ];
}
