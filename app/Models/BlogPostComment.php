<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BlogPostComment extends Model
{
    protected $table = "blog_post_comment";

    public function post(){
        return $this->belongsTo(BlogPost::class, "blog_post_id");
    }
}
