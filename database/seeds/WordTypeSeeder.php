<?php


class WordTypeSeeder extends \Illuminate\Database\Seeder
{
    public function run(){
        $types = ['radical', 'kanji', 'vocabulary'];

        foreach ($types as $type){
            $wordType = new \App\Models\WordType([
                'name' => $type
            ]);
            $wordType->timestamps = false;
            $wordType->save();
        }
    }
}
