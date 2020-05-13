<?php

namespace App\Console\Commands;

use App\Models\Kana;
use Illuminate\Console\Command;

class ImportKanas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:kanas {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = $this->argument('file');
        $json = file_get_contents($file);
        $kanas = json_decode($json, true);

        $countUpdated = 0;
        $countCreated = 0;

        foreach ($kanas as $kana) {

            $existingKana = Kana::query()->where('kana', $kana['kana']);

            if($existingKana->exists()){
                // Edit existing one
                $existingKana = $existingKana->firstOrFail();
                $existingKana->update([
                    'kana' => $kana['kana'],
                    'romaji' => $kana['romaji'],
                    'mnemonic' => $kana['mnemonic'],
                    'learn_order' => $kana['learn_order'],
                    'sound_file' => $kana['sound_file'] ?? ""
                ]);
                $existingKana->save();
                $countUpdated++;

            }else{
                // Create new one
                $newKana = new Kana([
                    'kana' => $kana['kana'],
                    'romaji' => $kana['romaji'],
                    'mnemonic' => $kana['mnemonic'],
                    'learn_order' => $kana['learn_order'],
                    'sound_file' => $kana['sound_file']
                ]);

                $newKana->save();
                $countCreated++;
            }

        }

        print("Created $countCreated kanas and updated $countUpdated\n");
    }
}
