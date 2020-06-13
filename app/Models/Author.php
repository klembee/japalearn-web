<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

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
        // Resize image

        $urlToSave = 'authors/' . $image->getFilename();
        $saveUrl = storage_path('app/public/' . $urlToSave);

        Image::make($image->getPathname())->fit(128, 128)->save($saveUrl);


        // Remove the "/public/" part before save in database
        $this->profile_picture_url = $urlToSave;
        $this->save();
    }
}
