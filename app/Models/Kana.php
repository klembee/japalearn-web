<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\File;

class Kana extends Model
{
    protected $table = "kanas";
    protected $fillable = [
        'kana',
        'romaji',
        'mnemonic',
        'learn_order'
    ];

    protected $appends = [
        'answers'
    ];

    public function getAnswersAttribute(){
        return [
            'readings' => [$this->kana],
        ];
    }
}
