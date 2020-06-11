<?php


class KanjiReadingToHiragana extends \Illuminate\Database\Seeder
{
    public function run(){
        foreach (\App\Models\VocabLearningPath::all() as $kanji){
            // Transform to hiragana
            foreach ($kanji->onReadings as $reading){
                $katakana = $reading->reading;
                $hiragana = "";

                foreach(mb_str_split($katakana) as $character){
                    if(\IntlChar::ord($character) >= 12449 && \IntlChar::ord($character) <= 12538){
                        $codePoint = \IntlChar::ord($character);
                        $hiragana .= \IntlChar::chr($codePoint - 96);
                    }else{
                        $hiragana .= $character;
                    }
                }

                $reading->reading = $hiragana;
                $reading->save();
            }

            // Remove the -... in the kun readings example: おなーじ　→　おな
            foreach($kanji->kunReadings as $reading){
                $reading->reading = explode("-", $reading->reading)[0];
                $reading->save();
            }
        }
    }
}
