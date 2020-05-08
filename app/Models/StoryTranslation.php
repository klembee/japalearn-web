<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class StoryTranslation extends Model
{
    protected $table = "story_translation";
    protected $fillable = [
        'japanese',
        'translation',
        'lang',
    ];

    public function story(){
        return $this->belongsTo(Story::class);
    }
}
