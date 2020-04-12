<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetLearningpathVocabIdToWord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vocab_learning_path', function (Blueprint $table) {
            $table->dropForeign(['vocabulary_id']);
            $table->dropColumn('vocabulary_id');
            $table->string('word');

            $table->foreignId('word_type_id')
                ->references('id')
                ->on('word_types')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vocab_learning_path', function (Blueprint $table) {
            $table->dropColumn('word');
            $table->dropForeign(['word_type_id']);

            $table->dropColumn('word_type_id');
            $table->foreignId('vocabulary_id');

            $table->foreign('vocabulary_id')
                ->references('id')
                ->on('vocabularies')
                ->onDelete("CASCADE");
        });
    }
}
