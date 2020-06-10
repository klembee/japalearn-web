<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrammarWordListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grammar_word_list', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grammar_item_id')
                ->references('id')
                ->on('grammar_learning_path')
                ->onDelete('CASCADE');
            $table->string('word');
            $table->string('reading')->nullable();
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
        Schema::table('grammar_word_list', function(Blueprint $table){
            $table->dropForeign(['grammar_item_id']);
        });
        Schema::dropIfExists('grammar_word_list');
    }
}
