<?php


class CountrySeeder extends \Illuminate\Database\Seeder
{
    public function run(){
        $countries = json_decode(file_get_contents('storage/scripts/countries.json'), true);

        foreach($countries as $c){
            $a = new \App\Models\Country([
                'code' => $c['code'],
                'name' => $c['name']
            ]);
            $a->save();
        }
    }
}
