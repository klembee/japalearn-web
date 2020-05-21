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
        $data = json_decode(file_get_contents("storage/scripts/mnemonics.json"));
        foreach ($data as $kanji => $mnemonic){
            $kanjiItem = VocabLearningPath::query()
                ->where('word_type_id', WordType::kanji()->id)
                ->where('word', $kanji)->first();

            if($kanjiItem){
                $kanjiItem->meaning_mnemonic = $mnemonic;
                $kanjiItem->save();
            }
        }
    }
}
