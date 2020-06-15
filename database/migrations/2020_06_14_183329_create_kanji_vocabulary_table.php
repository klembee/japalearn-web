<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKanjiVocabularyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kanji_vocabulary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kanji_id')
                ->references('id')
                ->on('kanji_learning_path')
                ->onDelete('CASCADE');

            $table->foreignId('vocabulary_id')
                ->references('id')
                ->on('vocabularies')
                ->onDelete('CASCADE');
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
        Schema::table('kanji_vocabulary', function(Blueprint $table){
            $table->dropForeign(['kanji_id']);
            $table->dropForeign(['vocabulary_id']);
        });
        Schema::dropIfExists('kanji_vocabulary');
    }
}
