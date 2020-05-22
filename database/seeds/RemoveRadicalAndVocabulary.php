<?php


class RemoveRadicalAndVocabulary extends \Illuminate\Database\Seeder
{
    public function run(){
        \App\Models\VocabLearningPath::query()
            ->where('word_type_id', '!=', \App\Models\WordType::kanji()->id)->delete();
    }
}
