<?php

namespace App\Console\Commands;

use App\Models\Kana;
use App\Models\VocabLearningPath;
use App\Models\VocabLearningPathExample;
use App\Models\VocabLearningPathMeanings;
use App\Models\VocabLearningPathReadings;
use App\Models\WordType;
use Illuminate\Console\Command;

class ImportKanjis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:kanjis {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import kanji, vocab and radical information';

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
        $kanjis = json_decode($json, true);

        $countUpdated = 0;
        $countCreated = 0;

        foreach ($kanjis as $kanji) {

            $existingKanji = VocabLearningPath::query()
                ->where('word', $kanji['word'])
                ->where('word_type_id', $kanji['word_type_id'])
                ->where('level', $kanji['level']);

            if($existingKanji->exists()){
                // Edit existing one
                $existingKanji = $existingKanji->firstOrFail();
                $existingKanji->update([
                    'word' => $kanji['word'],
                    'mnemonic' => $kanji['mnemonic'],
                    'word_type_id' => WordType::query()->where('name', $kanji['type'])->firstOrFail()->id,
                    'level' => $kanji['level']
                ]);
                $existingKanji->save();

                $this->updateExamples($existingKanji, $kanji['examples']);
                $this->updateMeanings($existingKanji, $kanji['meanings']);
                if($kanji['type'] != 'radical') {
                    $this->updateReadings($existingKanji, $kanji['readings']);
                }

                $countUpdated++;

            }else{
                // Create new one
                $newItem = new VocabLearningPath([
                    'word' => $kanji['word'],
                    'mnemonic' => $kanji['mnemonic'],
                    'word_type_id' => WordType::query()->where('name', $kanji['type'])->firstOrFail()->id,
                    'level' => $kanji['level']
                ]);

                $newItem->save();

                $this->updateExamples($newItem, $kanji['examples']);
                $this->updateMeanings($newItem, $kanji['meanings']);
                if($kanji['type'] != 'radical') {
                    $this->updateReadings($newItem, $kanji['readings']);
                }

                $countCreated++;
            }

        }

        print("Created $countCreated kanas and updated $countUpdated\n");
    }


    private function updateExamples(VocabLearningPath $kanji, $examples){

        foreach($examples as $example){
            $existing = VocabLearningPathExample::query()
                ->where('vocab_learning_path_item_id', $kanji->id)
                ->where('example', $example['example']);

            if($existing->exists()){
                // Update the example
                $existing = $existing->firstOrFail();
                $existing->update([
                    'example' => $example['example'],
                    'translation' => $example['example'],
                    'type' => $example['type'], 1
                ]);
                $existing->save();
            }else{
                // Create a new one
                $kanji->examples()->save(new VocabLearningPathExample([
                    'example' => $example['example'],
                    'translation' => $example['example'],
                    'type' => $example['type'], 1
                ]));
            }
        }
    }

    private function updateMeanings(VocabLearningPath $kanji, $meanings){
        foreach($meanings as $meaning){
            $existing = VocabLearningPathMeanings::query()
                ->where('vocab_learning_path_item_id', $kanji->id)
                ->where('meaning', $meaning['meaning']);

            if($existing->exists()){
                // Update the example
                $existing = $existing->firstOrFail();
                $existing->update([
                    'meaning' => $meaning['meaning'],
                ]);
                $existing->save();
            }else{
                // Create a new one
                $kanji->meanings()->save(new VocabLearningPathMeanings([
                    'meaning' => $meaning['meaning']
                ]));
            }
        }
    }

    private function updateReadings(VocabLearningPath $kanji, $readings){
        foreach($readings as $reading){
            $existing = VocabLearningPathReadings::query()
                ->where('vocab_learning_path_item_id', $kanji->id)
                ->where('reading', $reading['reading']);

            if($existing->exists()){
                // Update the reading
                $existing = $existing->firstOrFail();
                $existing->update([
                    'reading' => $reading['reading'],
                ]);
                $existing->save();
            }else{
                // Create a new one
                $kanji->readings()->save(new VocabLearningPathReadings([
                    'reading' => $reading['reading']
                ]));
            }
        }
    }
}
