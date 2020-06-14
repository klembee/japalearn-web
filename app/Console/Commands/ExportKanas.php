<?php

namespace App\Console\Commands;

use App\Models\Kana;
use App\Models\KanjiLearningPath;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExportKanas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:kanas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export the kanas to make it easier to import them later';

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
        $json = Kana::query()->get()->toJson();
        $date = Carbon::now()->format("Y-m-d-h-i-s");
        $file = "storage/exports/kanas-$date.json";
        file_put_contents($file, $json);

        print("Exported kanas and vocabulary to $file\n");
    }
}
