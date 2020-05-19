<?php


class FixSlug extends \Illuminate\Database\Seeder
{
    public function run(){
        foreach (\App\Models\GrammarLearningPathItem::all() as $grammar){
            $grammar->slug =  strtolower(str_replace(' ', "_", trim(preg_replace('/[^A-Za-z0-9_\s]/', '', $grammar->title))));
            $grammar->save();
        }

        foreach(\App\Models\Story::all() as $story){
            $story->slug =  strtolower(str_replace(' ', "_", trim(preg_replace('/[^A-Za-z0-9_\s]/', '', $story->title))));
            $story->save();
        }
    }
}
