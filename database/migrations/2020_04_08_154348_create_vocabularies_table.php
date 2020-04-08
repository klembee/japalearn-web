<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVocabulariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vocabularies', function (Blueprint $table) {
            $table->id();
            $table->string('word');
            $table->text('mnemonic')->nullable();
            $table->timestamps();
        });

        Schema::create('vocabulary_writing', function(Blueprint $table){
            $table->id();
            $table->foreignId('vocabulary_id');
            $table->string('writing');
            $table->text('mnemonic')->nullable();
            $table->timestamps();

            $table->foreign('vocabulary_id')
                ->references('id')
                ->on('vocabularies')
                ->onDelete('CASCADE');
        });

        Schema::create('vocabulary_meaning', function(Blueprint $table){
            $table->id();
            $table->foreignId('vocabulary_id');
            $table->string('meaning');
            $table->text('mnemonic')->nullable();
            $table->timestamps();

            $table->foreign('vocabulary_id')
                ->references('id')
                ->on('vocabularies')
                ->onDelete('CASCADE');
        });

        Schema::create('pos', function(Blueprint $table){
           $table->id();
           $table->string('pos')->unique();
        });

        Schema::create('vocabulary_pos', function(Blueprint $table){
            $table->id();
            $table->foreignId('vocabulary_id');
            $table->foreignId('pos_id');

            $table->foreign('vocabulary_id')
                ->references('id')
                ->on('vocabularies')
                ->onDelete('CASCADE');

            $table->foreign('pos_id')
                ->references('id')
                ->on('pos')
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
        Schema::table('vocabulary_writing', function(Blueprint $table){
            $table->dropForeign(['vocabulary_id']);
        });
        Schema::dropIfExists('vocabulary_writing');

        Schema::table('vocabulary_meaning', function(Blueprint $table){
            $table->dropForeign(['vocabulary_id']);
        });
        Schema::dropIfExists('vocabulary_meaning');

        Schema::table('vocabulary_pos', function(Blueprint $table){
            $table->dropForeign(['vocabulary_id']);
            $table->dropForeign(['pos_id']);
        });
        Schema::dropIfExists('vocabulary_pos');
        Schema::dropIfExists('pos');

        Schema::dropIfExists('vocabularies');
    }
}
