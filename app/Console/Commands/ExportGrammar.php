<?php

namespace App\Console\Commands;

use App\Models\Kana;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExportGrammar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:grammar';

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
//        $categories = GrammarCa::query()->get()->toJson();
//        $date = Carbon::now()->format("Y-m-d-h-i-s");
//        $file = "storage/exports/kanas-$date.json";
//        file_put_contents($file, $json);
//
//        print("Exported kanas and vocabulary to $file\n");
    }
}
