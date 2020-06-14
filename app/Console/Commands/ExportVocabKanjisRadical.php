<?php

namespace App\Console\Commands;

use App\Models\KanjiLearningPath;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExportVocabKanjisRadical extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:kanjis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export the kanas, vocab and grammar learning path items in the json format. That can then be imported later.';

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
        $json = KanjiLearningPath::query()->with('examples')->get()->toJson();
        $date = Carbon::now()->format("Y-m-d-h-i-s");
        $file = "storage/exports/kanjis-$date.json";
        file_put_contents($file, $json);

        print("Exported kanjis and vocabulary to $file\n");
    }
}
