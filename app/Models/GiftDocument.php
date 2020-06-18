<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class GiftDocument extends Model
{
    protected $table = "gift_document";

    protected $fillable = [
        'document_path'
    ];
}
