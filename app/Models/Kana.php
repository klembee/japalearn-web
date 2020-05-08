<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\File;

class Kana extends Model
{
    protected $table = "kanas";
    protected $fillable = [
        'kana',
        'romaji',
        'mnemonic',
        'learn_order',
        'sound_file'
    ];

    protected $appends = [
        'answers',
        'level'
    ];

    public function getAnswersAttribute(){
        return [
            'readings' => [$this->kana],
        ];
    }

    public function getLevelAttribute(){
        $user = Auth::user();
        if(!$user->isStudent()){
            return 0;
        }

        try {
            return $user->info->information->kanaLearningPathStats()->where('kana_id', $this->id)->firstOrFail()->number_right;
        }catch (\Exception $e){
            return 0;
        }
    }
}
