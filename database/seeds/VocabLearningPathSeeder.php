<?php


class VocabLearningPathSeeder extends \Illuminate\Database\Seeder
{
    function file_get_contents_utf8($fn) {
        $content = file_get_contents($fn);
        return mb_convert_encoding($content, 'UTF-8',
            mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
    }

    public function run(){
//        $kanjis_json = file_get_contents('database/seeds/levels.json');
//        $kanjis = json_decode($kanjis_json, true);
//
//        foreach($kanjis as $levelCount => $level){
//            foreach ($level as $kanji){
////                error_log($levelCount . " " . $kanji['kanji']);
//
//                $item = new \App\Models\VocabLearningPath([
//                    'level' => $levelCount + 1,
//                    'word' => $kanji['kanji'],
//                    'word_type_id' => \App\Models\WordType::kanji()->id
//                ]);
//
//                $item->save();
//
//                foreach($kanji['meanings'] as $meaning){
//                    $meaningItem = new \App\Models\VocabLearningPathMeanings([
//                        'vocab_learning_path_item_id' => $item->id,
//                        'meaning' => $meaning
//                    ]);
//
//                    $meaningItem->save();
//                }
//
//                foreach($kanji['on_readings'] as $reading){
//                    $readingItem = new \App\Models\VocabLearningPathReadings([
//                        'vocab_learning_path_item_id' => $item->id,
//                        'reading' => $reading
//                    ]);
//
//                    $readingItem->save();
//                }
//
//            }
//        }

//        $vocab_json = file_get_contents('database/seeds/vocab_by_level.json');
//        $vocab = json_decode($vocab_json, true);
//
//        foreach($vocab as $levelCount => $level){
//            foreach($level as $vocabulary){
//                $item = new \App\Models\VocabLearningPath([
//                    'level' => $levelCount + 1,
//                    'word' => $vocabulary['word'],
//                    'word_type_id' => \App\Models\WordType::vocabulary()->id
//                ]);
//
//                $item->save();
//
//                foreach($vocabulary['meanings'] as $meaning){
//                    $meaningItem = new \App\Models\VocabLearningPathMeanings([
//                        'vocab_learning_path_item_id' => $item->id,
//                        'meaning' => $meaning
//                    ]);
//
//                    $meaningItem->save();
//                }
//
//                $readingItem = new \App\Models\VocabLearningPathReadings([
//                    'vocab_learning_path_item_id' => $item->id,
//                    'reading' => $vocabulary['reading']
//                ]);
//
//                $readingItem->save();
//            }
//        }

        $radical_json = $this->file_get_contents_utf8('database/seeds/kanji_with_radical.json');
        $radical = json_decode($radical_json, true);

        //todo: read unicode

//        foreach($radical as $levelCount => $level){
//            foreach($level as $rad){
//                print($rad);
//
//                $item = new \App\Models\VocabLearningPath([
//                    'level' => $levelCount + 1,
//                    'word' => $rad,
//                    'word_type_id' => \App\Models\WordType::radical()->id
//                ]);
//
//                $item->save();
//            }
//        }


    }
}
