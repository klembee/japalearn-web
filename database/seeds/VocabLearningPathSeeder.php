<?php


class VocabLearningPathSeeder extends \Illuminate\Database\Seeder
{
    function file_get_contents_utf8($fn) {
        $content = file_get_contents($fn);
        return mb_convert_encoding($content, 'UTF-8',
            mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
    }

    public function run(){
        $kanjis_json = file_get_contents('database/seeds/levels.json');
        $kanjis = json_decode($kanjis_json, true);

        foreach($kanjis as $levelCount => $level){
            foreach ($level as $kanji){
                $item = new \App\Models\VocabLearningPath([
                    'level' => $levelCount + 1,
                    'word' => $kanji['kanji'],
                    'word_type_id' => \App\Models\WordType::kanji()->id
                ]);

                $item->save();

                foreach($kanji['meanings'] as $meaning){
                    $meaningItem = new \App\Models\VocabLearningPathMeanings([
                        'vocab_learning_path_item_id' => $item->id,
                        'meaning' => $meaning
                    ]);

                    $meaningItem->save();
                }

                foreach($kanji['on_readings'] as $reading){
                    $readingItem = new \App\Models\VocabLearningPathReadings([
                        'vocab_learning_path_item_id' => $item->id,
                        'reading' => $reading
                    ]);

                    $readingItem->save();
                }

            }
        }

        $vocab_json = file_get_contents('database/seeds/vocab_by_level.json');
        $vocab = json_decode($vocab_json, true);

        foreach($vocab as $levelCount => $level){
            foreach($level as $vocabulary){
                $item = new \App\Models\VocabLearningPath([
                    'level' => $levelCount + 1,
                    'word' => $vocabulary['word'],
                    'word_type_id' => \App\Models\WordType::vocabulary()->id
                ]);

                $item->save();

                foreach($vocabulary['meanings'] as $meaning){
                    $meaningItem = new \App\Models\VocabLearningPathMeanings([
                        'vocab_learning_path_item_id' => $item->id,
                        'meaning' => $meaning
                    ]);

                    $meaningItem->save();
                }

                $readingItem = new \App\Models\VocabLearningPathReadings([
                    'vocab_learning_path_item_id' => $item->id,
                    'reading' => $vocabulary['reading']
                ]);

                $readingItem->save();
            }
        }

        // Create the radicals
        $radical_json = mb_convert_encoding($this->file_get_contents_utf8('database/seeds/kanji_radical.json'), "UTF-8");
        $radical = json_decode($radical_json, true);

        foreach($radical as $levelCount => $level){
            foreach($level as $rad){

                $item = new \App\Models\VocabLearningPath([
                    'level' => $levelCount + 1,
                    'word' => $rad,
                    'word_type_id' => \App\Models\WordType::radical()->id
                ]);

                $item->save();
            }
        }


        # Convert kanji reading from katakana to hiragana
        $kanjis = \App\Models\VocabLearningPath::query()->where('word_type_id', \App\Models\WordType::kanji()->id)->get();
        foreach ($kanjis as $kanji){
            $readings = $kanji->readings;
            foreach($readings as $reading){
                $newReading = "";
                foreach (mb_str_split($reading->reading) as $letter){
                    $unicode = IntlChar::ord($letter);
                    $newChar = "";
                    if($unicode >= 12448 && $unicode <= 12538){
                        # This is katakana
                        $newChar = IntlChar::chr($unicode -= 96);
                        $newReading .= $newChar;
                    }else{
                        $newReading .= $letter;
                    }
                }

                $reading->reading = $newReading;
                $reading->save();
            }
        }

        # Separate meanings containing ';'
        $items = \App\Models\VocabLearningPath::query()
            ->where('word_type_id', '!=', \App\Models\WordType::radical()->id)->get();

        foreach ($items as $item){
            $meanings = $item->meanings;
            foreach ($meanings as $meaning){
                $sub_meanings = explode(';', $meaning->meaning);
                foreach($sub_meanings as $sub_meaning){
                    $item->meanings()->save(new \App\Models\VocabLearningPathMeanings([
                        'meaning' => $sub_meaning
                    ]));
                }
                $meaning->delete();
            }
        }

    }
}
