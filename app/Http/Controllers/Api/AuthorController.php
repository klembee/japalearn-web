<?php


namespace App\Http\Controllers\Api;


use App\Helpers\PictureUploaderHelper;
use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function create(Request $request){
        $this->validate($request, [
            'name' => 'required'
        ]);

        $name = $request->input('name');

        $author = new Author([
            'name' => $name,
            'bio' => $request->input('bio')
        ]);

        if($request->has('imageData')){
            $base64image = $request->input('imageData');
            $imageFile = PictureUploaderHelper::uploadFile($base64image);
            $author->setProfileImage($imageFile);
        }

        $author->save();

        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }
}
