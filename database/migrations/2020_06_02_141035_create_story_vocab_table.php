<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoryVocabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('story_vocab', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')
                ->references('id')
                ->on('stories')
                ->onDelete('CASCADE');

            $table->string('word');
            $table->string('reading');
            $table->string('meaning');

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
        Schema::table('story_vocab', function(Blueprint $table){
            $table->dropForeign(['story_id']);
        });
        Schema::dropIfExists('story_vocab');
    }
}
