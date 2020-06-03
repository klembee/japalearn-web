<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BlogPostComment extends Model
{
    protected $table = "blog_post_comment";
    protected $appends = [
        'parsed_date'
    ];

    protected $fillable = [
        'author_email',
        'author_name',
        'comment'
    ];

    protected $dates = [
        'created_at'
    ];

    public function post(){
        return $this->belongsTo(BlogPost::class, "blog_post_id");
    }

    public function getParsedDateAttribute(){
        return $this->created_at->format('Y-m-d \a\t H:i');
    }
}
