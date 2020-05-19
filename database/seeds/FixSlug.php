<?php


class FixSlug extends \Illuminate\Database\Seeder
{
    public function run(){
        foreach (\App\Models\GrammarLearningPathItem::all() as $grammar){
            $grammar->slug =  preg_replace('/[^A-Za-z0-9_\-]/', '', strtolower(str_replace(' ', "_", $grammar->title)));
            $grammar->save();
        }

        foreach(\App\Models\Story::all() as $story){
            $story->slug =  preg_replace('/[^A-Za-z0-9_\-]/', '', strtolower(str_replace(' ', "_", $story->title)));
            $story->save();
        }
    }
}
