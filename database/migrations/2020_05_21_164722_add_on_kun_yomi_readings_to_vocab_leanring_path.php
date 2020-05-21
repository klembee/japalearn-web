<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOnKunYomiReadingsToVocabLeanringPath extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kanji_learning_path_kun', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kanji_id')
                ->references('id')
                ->on('vocab_learning_path')
                ->onDelete('CASCADE');
            $table->string('reading');
            $table->timestamps();
        });

        Schema::create('kanji_learning_path_on', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kanji_id')
                ->references('id')
                ->on('vocab_learning_path')
                ->onDelete('CASCADE');
            $table->string('reading');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kanji_learning_path_kun', function (Blueprint $table) {
            $table->dropForeign(['kanji_id']);
        });
        Schema::dropIfExists('kanji_learning_path_kun');

        Schema::table('kanji_learning_path_on', function (Blueprint $table) {
            $table->dropForeign(['kanji_id']);
        });
        Schema::dropIfExists('kanji_learning_path_on');
    }
}
