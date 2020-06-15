<?php

namespace App\Console\Commands;

use App\Models\KanjiLearningPath;
use App\Models\Vocabulary;
use Illuminate\Console\Command;

class ImportVocab extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:vocab';

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
        $vocabs = json_decode(file_get_contents('storage/scripts/common_words.json'), true);
        
        foreach ($vocabs as $vocab){
            // Create a new vocab
            $vocabObj = new Vocabulary([
                'word' => $vocab['kanji']
            ]);

            $vocabObj->save();

            foreach ($vocab['readings'] as $reading){
                $vocabObj->readings()->create([
                    'writing' => $reading
                ]);
            }

            foreach($vocab['meanings'] as $meaning){
                $vocabObj->meanings()->create([
                    'meaning' => $meaning
                ]);
            }

            foreach (mb_str_split($vocab['kanji']) as $character){
                $kanji = KanjiLearningPath::query()->where('word', $character);
                if($kanji->exists()){
                    $vocabObj->kanjis()->attach($kanji->firstOrFail()->id);
                }
            }
        }
    }
}
