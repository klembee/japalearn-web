<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsMainToMeaningsReadings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kanji_learning_path_on', function (Blueprint $table) {
            $table->boolean('is_main')->default(false);
        });

        Schema::table('kanji_learning_path_kun', function (Blueprint $table) {
            $table->boolean('is_main')->default(false);
        });

        Schema::table('vocab_learning_path_meanings', function (Blueprint $table) {
            $table->boolean('is_main')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kanji_learning_path_on', function (Blueprint $table) {
            $table->dropColumn('is_main');
        });

        Schema::table('kanji_learning_path_kun', function (Blueprint $table) {
            $table->dropColumn('is_main');
        });

        Schema::table('vocab_learning_path_meanings', function (Blueprint $table) {
            $table->dropColumn('is_main');
        });
    }
}
