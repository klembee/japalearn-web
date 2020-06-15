<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVocabAndRemovePOS extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vocabularies', function(Blueprint $table){
             $table->dropForeign(['word_type_id']);
             $table->dropColumn(['word_type_id', 'commonity', 'jmdict_id']);
        });

        Schema::table('vocabulary_pos', function(Blueprint $table){
            $table->dropForeign(['vocabulary_id']);
            $table->dropForeign(['pos_id']);
        });
        Schema::dropIfExists('vocabulary_pos');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vocabularies', function(Blueprint $table){
            $table->foreign('word_type_id')
                ->references('id')
                ->on('word_types')
                ->onDelete('CASCADE');
            $table->integer('commonity',false, true);
            $table->integer('jmdict_id', false, true)->nullable();
        });

        Schema::create('vocabulary_pos', function(Blueprint $table){
            $table->id();
            $table->foreignId('vocabulary_id')
                ->references('id')
                ->on('vocabularies')
                ->onDelete('CASCADE');

            $table->foreignId('pos_id')
                ->references('id')
                ->on('pos')
                ->onDelete('CASCADE');
        });
    }
}
