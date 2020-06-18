<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Gift extends Model
{
    protected $table = "gifts";

    protected $fillable = [
        'title',
        'description',
        'image_url'
    ];

    public function documents(){
        return $this->hasMany(GiftDocument::class, 'gift_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

}
