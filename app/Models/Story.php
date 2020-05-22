<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Story extends Model
{
    protected $table = "stories";
    protected $fillable = [
        'title',
        'content',
        'keywords',
        'front_image_url',
        'meta_description',
        'slug',
        'description',
        'meta_description'
    ];

    public function questions(){
        return $this->hasMany(StoryQuestion::class);
    }

    public function author(){
        return $this->belongsTo(Author::class);
    }

//    public function translations(){
//        return $this->hasMany(StoryTranslation::class, 'story_id');
//    }

    public function setFrontImage(UploadedFile $file){
        $savedFile = $file->store('public/stories');

        // Remove the "/public/" part before save in database
        $path = substr($savedFile, strpos($savedFile, "/") + 1);
        $this->front_image_url = $path;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
