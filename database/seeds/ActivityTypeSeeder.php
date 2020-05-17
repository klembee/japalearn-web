<?php


class ActivityTypeSeeder extends \Illuminate\Database\Seeder
{
    private $types = [
        'kana_learned',
        'kana_reviewed',
        'kanji_learned',
        'kanji_reviewed',
        'grammar_lesson_learned',
        'story_read'
    ];

    public function run(){
        foreach($this->types as $type){
            $activtyType = new \App\Models\ActivityType([
                'name' => $type
            ]);

            $activtyType->save();
        }
    }
}
