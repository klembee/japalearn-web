<?php


class AttachRadicalsToKanjisSeeder extends \Illuminate\Database\Seeder
{
    public function run(){
        $file = file_get_contents('database/seeds/kanji_radical.json');
        $kanjiRadical = json_decode($file);

        foreach($kanjiRadical as $kanji => $radicals){
            $kanjiItem = \App\Models\VocabLearningPath::query()
                ->where('word_type_id', \App\Models\WordType::kanji()->id)
                ->where('word', $kanji)->first();

            if($kanjiItem){
                foreach ($radicals as $radical){
                    $radicalItem = \App\Models\Radical::query()
                        ->where('radical', $radical)->first();

                    if($radicalItem){
                        $kanjiItem->radicals()->attach($radicalItem);
                    }


                }
            }
        }
    }
}
