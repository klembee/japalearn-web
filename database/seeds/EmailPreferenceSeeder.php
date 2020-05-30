<?php


class EmailPreferenceSeeder extends \Illuminate\Database\Seeder
{
    private $preferences = [
        // to Students
        "appointment.confirmation" => 'Get notified when a teacher confirms a video lesson with you.',
        "appointment.ask_rating" => "Get notified after a video lesson to leave a review for your teacher.",
        "appointment.starts_soon" => "Get notified fifteen minutes before a video lesson starts.",
        "learning.item_levelup" => "Get notified when you reach a new level.",

        // to teachers
//        "appointment.new" => "Get notified when a student " Ca c'est obligatoire.
    ];

    public function run(){
        $currentPreferences = \App\Models\EmailPreference::query()->get()->pluck('code')->toArray();

        foreach ($this->preferences as $code => $description){
            if(!in_array($code, $currentPreferences)){
                $pref = new \App\Models\EmailPreference([
                    'code' => $code,
                    'description' => $description
                ]);
                $pref->save();
            }
        }
    }
}
