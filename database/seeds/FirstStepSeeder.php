<?php


use Illuminate\Database\Seeder;

class FirstStepSeeder extends Seeder
{
    private $steps = [
        'Take your first grammar lesson',
        'Learn the first 10 kanas',
        'Learn your first kanji',
        'Wait and do your kana reviews',
        'Wait and do your kanji reviews'
    ];

    public function run(){
        foreach ($this->steps as $step){
            $newStep = new \App\Models\AccountFirstStep([
                'step' => $step
            ]);
            $newStep->save();
        }
    }
}
