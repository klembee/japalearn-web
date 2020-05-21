<?php

namespace App\Console\Commands;

use App\Models\VocabLearningPath;
use App\Models\WordType;
use Illuminate\Console\Command;

class ImportJoyo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:joyo';

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
        $data = json_decode(file_get_contents("storage/scripts/mnemonics.json"), true);
        foreach ($data as $kanji => $data){
            $kanjiItem = VocabLearningPath::query()
                ->where('word_type_id', WordType::kanji()->id)
                ->where('word', $kanji)->first();

            if($kanjiItem){
                $kanjiItem->meaning_mnemonic = $data['mnemonic'];
                $kanjiItem->save();

                $kanjiItem->meanings()->delete();
                $kanjiItem->readings()->delete();
                $kanjiItem->onReadings()->delete();
                $kanjiItem->kunReadings()->delete();

                foreach($data['on'] as $onReading){
                    if(mb_strlen($onReading) > 0) {
                        $kanjiItem->onReadings()->create([
                            'reading' => $onReading
                        ]);
                    }
                }

                foreach($data['kun'] as $kunReading){
                    if(mb_strlen($kunReading) > 0) {
                        $kanjiItem->kunReadings()->create([
                            'reading' => $kunReading
                        ]);
                    }
                }

                foreach($data['meanings'] as $meaning){
                    $kanjiItem->meanings()->create([
                        'meaning' => $meaning
                    ]);
                }

            }
        }
    }
}
