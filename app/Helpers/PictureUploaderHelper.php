<?php


namespace App\Helpers;


use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class PictureUploaderHelper
{
    /**
     * Uploads a base64 encoded file into tmp storage
     * @param $picture_base64
     * @return UploadedFile
     */
    public static function uploadFile($picture_base64){
        $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $picture_base64));

        $tmpFilePath = sys_get_temp_dir() . "/" . Str::uuid()->toString();
        file_put_contents($tmpFilePath, $fileData);

        $tmpFile = new File($tmpFilePath);

        return new UploadedFile(
            $tmpFile->getPathname(),
            $tmpFile->getFilename(),
            $tmpFile->getMimeType(),
            0,
            true
        );
    }
}
