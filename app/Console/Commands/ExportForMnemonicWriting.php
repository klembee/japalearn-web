<?php

namespace App\Console\Commands;

use App\Models\VocabLearningPath;
use App\Models\WordType;
use Illuminate\Console\Command;

class ExportForMnemonicWriting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:mnemonicWriting {level}';

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
        $level = $this->argument('level');

        $learning_path_items = VocabLearningPath::query()
            ->where('level', $level)
            ->where('word_type_id', '!=', WordType::vocabulary()->id)->get()->groupBy('level');

        foreach($learning_path_items as $level => $items){

            $content = "LEVEL $level\n\n";
            $items = $items->sortBy('word_type_id');

            $startedRadical = false;
            $startedKanjis = false;

            foreach ($items as $item){
                if($item->word_type_id == WordType::kanji()->id){
                    if(!$startedKanjis){
                        $content .= "KANJIS\n\n";
                        $startedKanjis = true;
                    }

                    $content .= "\t" . $item->word . "(radicals: ". implode(', ', $item->radicals->pluck('radical')->toArray()) .")\n";
                    $content .= "\tMeanings: " . implode(", ", $item->meanings->pluck('meaning')->toArray()) . "\n";
                    $content .= "\tReadings: " .implode(", ", $item->readings->pluck('reading')->toArray()) . "\n";
                    $content .= "\t\tMeaning mnemonic: \n";
                    $content .= "\t\tReading mnemonic: \n\n";

                }else if($item->word_type_id == WordType::radical()->id){
                    if(!$startedRadical){
                        $content .= "\nRADICALS\n\n";
                        $startedRadical = true;
                    }

                    $content .= "\t" . $item->word . " (" . implode(", ", $item->meanings->pluck('meaning')->toArray()) .")\n";

                    $content .= "\t\tMeaning mnemonic: \n\n";
                }
            }

            file_put_contents("task-$level.txt", $content);
        }
    }
}
