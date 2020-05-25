<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNbTriesToKanaKanjiItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kana_student', function (Blueprint $table) {
            $table->integer('nb_tries', false, true)->default(1);
        });

        Schema::table('vocab_learning_path_item_student', function (Blueprint $table) {
            $table->integer('nb_tries', false, true)->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kana_student', function (Blueprint $table) {
            $table->dropColumn('nb_tries', false, true);
        });

        Schema::table('vocab_learning_path_item_student', function (Blueprint $table) {
            $table->dropColumn('nb_tries', false, true);
        });
    }
}
