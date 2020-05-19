<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BlogPostKeyword extends Model
{
    protected $table = "blog_post_keyword";


    public function post(){
        return $this->belongsTo(BlogPost::class, 'blog_post_id');
    }
}
