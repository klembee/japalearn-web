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
        'author_id'
    ];

    protected $appends = [
        'url',
        'abstract',
        'formated_date'
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

    public function getFormatedDateAttribute(){
        return $this->created_at->format('F jS Y');
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

    public function getAbstractAttribute(){
        $markdownParser = new \Parsedown();
        $parsedContent = strip_tags(str_replace('</', '. </', $markdownParser->text($this->content)));

        return mb_substr($parsedContent, 0, 100) . "...";
    }

    public function getUrlAttribute(){
        return route('frontpage.blog.view', $this);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
