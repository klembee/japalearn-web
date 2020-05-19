<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class BlogPost extends Model
{

    protected $table = "blog_posts";

    protected $fillable = [
        'title',
        'content',
        'meta_description',
        'slug',
    ];

    public function author(){
        return $this->belongsTo(Author::class);
    }

    public function comments(){
        return $this->hasMany(BlogPostComment::class);
    }

    public function keywords(){
        return $this->hasMany(BlogPostKeyword::class);
    }

    /**
     * Attach a image to the blog post
     * @param UploadedFile $file
     */
    public function attachPicture(UploadedFile $file){
        $savedFile = $file->store('public/blog');

        // Remove the "/public/" part before save in database
        $path = substr($savedFile, strpos($savedFile, "/") + 1);
        $this->image_url = $path;
        $this->save();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
