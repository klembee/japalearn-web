<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Author extends Model
{
    protected $table = "authors";
    protected $fillable = [
        'name',
        'bio'
    ];

    public function stories(){
        return $this->hasMany(Story::class);
    }

    /**
     * Save the profile image and set the url in the database
     * @param UploadedFile $image
     */
    public function setProfileImage(UploadedFile $image){
        $savedFile = $image->store('public/authors');

        // Remove the "/public/" part before save in database
        $path = substr($savedFile, strpos($savedFile, "/") + 1);

        $this->profile_picture_url = $path;
        $this->save();
    }
}
