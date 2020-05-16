<?php


class RadicalsSeeder extends \Illuminate\Database\Seeder
{
    public function run(){
        $radicalFile = file_get_contents('database/seeds/radicals.json');
        $radicals = json_decode($radicalFile);

        // The radicals are separated by level in this file
        foreach ($radicals as $level){
            foreach($level as $radical){
                $newRadical = new \App\Models\Radical([
                    'radical' => $radical
                ]);
                $newRadical->save();
            }
        }
    }
}
