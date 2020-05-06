<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $table = "stories";
    protected $fillable = [
        'title',
        'content',
        'keywords',
        'front_image_url'
    ];

    public function questions(){
        return $this->hasMany(StoryQuestion::class);
    }
}
