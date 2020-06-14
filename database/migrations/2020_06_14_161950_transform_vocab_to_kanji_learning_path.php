<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TransformVocabToKanjiLearningPath extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vocab_learning_path', function (Blueprint $table) {
            $table->dropForeign(['word_type_id']);

            $table->dropColumn(['word_type_id', 'reading_mnemonic']);
            $table->renameColumn('meaning_mnemonic', 'mnemonic');
        });

        Schema::rename('vocab_learning_path', 'kanji_learning_path');

        Schema::dropIfExists('vocab_learning_path_examples');
        Schema::rename('vocab_learning_path_item_student', 'kanji_learning_path_item_student');

        Schema::table('vocab_learning_path_meanings', function(Blueprint $table){
            $table->dropForeign(['vocab_learning_path_item_id']);
            $table->renameColumn('vocab_learning_path_item_id', 'kanji_id');
            $table->foreign('kanji_id')
                ->references('id')
                ->on('kanji_learning_path')
                ->onDelete('CASCADE');
        });

        Schema::rename('vocab_learning_path_meanings', 'kanji_learning_path_meanings');

        Schema::dropIfExists('vocab_learning_path_readings');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
