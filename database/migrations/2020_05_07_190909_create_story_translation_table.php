<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoryTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('story_translation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')
                ->references('id')
                ->on('stories')
                ->onDelete('CASCADE');
            $table->string('lang')->default('en');
            $table->string('japanese');
            $table->string('translation');
            $table->timestamps();

            $table->unique(['story_id', 'japanese', 'translation']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('story_translation', function(Blueprint $table){
            $table->dropForeign(['story_id']);
        });
        Schema::dropIfExists('story_translation');
    }
}
