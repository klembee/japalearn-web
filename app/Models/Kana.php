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

    /**
     * Get all the hiraganas
     */
    public static function hiraganas(){
        $allKanas = Kana::all()->pluck('kana')->toArray();
        $onlyHiraganas = [];

        foreach ($allKanas as $kana){
            foreach(mb_str_split($kana) as $character){
                if(\IntlChar::ord($character) >= 12353 && \IntlChar::ord($character) <= 12438){
                    $onlyHiraganas[] = $kana;
                    break;
                }
            }

        }

        return Kana::query()->whereIn('kana', $onlyHiraganas);
    }

    /**
     * Get all the katakanas
     */
    public static function katakanas(){
        $allKanas = Kana::all()->pluck('kana')->toArray();
        $onlyKatakana = [];

        foreach ($allKanas as $kana){
            foreach(mb_str_split($kana) as $character){
                if(\IntlChar::ord($character) >= 12449 && \IntlChar::ord($character) <= 12538){
                    $onlyKatakana[] = $kana;
                    break;
                }
            }

        }

        return Kana::query()->whereIn('kana', $onlyKatakana);
    }

    public function getLevelAttribute(){
        $user = Auth::user();
        if($user == null || !$user->isStudent()){
            return 0;
        }

        try {
            return $user->info->kanaLearningPathStats()->where('kana_id', $this->id)->firstOrFail()->number_right;
        }catch (\Exception $e){
            return 0;
        }
    }
}
