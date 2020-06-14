<?php


class RemoveRadicalAndVocabulary extends \Illuminate\Database\Seeder
{
    public function run(){
        \App\Models\KanjiLearningPath::query()
            ->where('word_type_id', '!=', \App\Models\WordType::kanji()->id)->delete();
    }
}
