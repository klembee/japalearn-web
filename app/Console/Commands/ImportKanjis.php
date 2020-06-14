<?php

namespace App\Console\Commands;

use App\Models\Kana;
use App\Models\KanjiLearningPath;
use App\Models\VocabLearningPathExample;
use App\Models\KanjiLearningPathMeanings;
use App\Models\KanjiLearningPathReadings;
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

            $existingKanji = KanjiLearningPath::query()
                ->where('word', $kanji['word'])
                ->where('word_type_id', $kanji['word_type_id'])
                ->where('level', $kanji['level']);

            if($existingKanji->exists()){
                // Edit existing one
                $existingKanji = $existingKanji->firstOrFail();
                $existingKanji->update([
                    'word' => $kanji['word'],
                    'meaning_mnemonic' => $kanji['meaning_mnemonic'],
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
                $newItem = new KanjiLearningPath([
                    'word' => $kanji['word'],
                    'meaning_mnemonic' => $kanji['meaning_mnemonic'],
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


    private function updateExamples(KanjiLearningPath $kanji, $examples){

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

    private function updateMeanings(KanjiLearningPath $kanji, $meanings){
        foreach($meanings as $meaning){
            $existing = KanjiLearningPathMeanings::query()
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
                $kanji->meanings()->save(new KanjiLearningPathMeanings([
                    'meaning' => $meaning['meaning']
                ]));
            }
        }
    }

    private function updateReadings(KanjiLearningPath $kanji, $readings){
        foreach($readings as $reading){
            $existing = KanjiLearningPathReadings::query()
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
                $kanji->readings()->save(new KanjiLearningPathReadings([
                    'reading' => $reading['reading']
                ]));
            }
        }
    }
}
