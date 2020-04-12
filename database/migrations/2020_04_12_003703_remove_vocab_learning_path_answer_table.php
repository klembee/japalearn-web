<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveVocabLearningPathAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vocab_learning_path_answers', function(Blueprint $table){
            $table->dropForeign(['vocab_learning_path_item_id']);
        });
        Schema::dropIfExists('vocab_learning_path_answer');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('vocab_learning_path_answer', function(Blueprint $table){
            $table->foreignId("vocab_learning_path_item_id");
            #todo here
        });
    }
}
