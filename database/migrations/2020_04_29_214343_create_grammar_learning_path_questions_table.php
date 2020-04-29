<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrammarLearningPathQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grammar_learning_path_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grammar_item_id');
            $table->text("question");
            $table->timestamps();

            $table->foreign('grammar_item_id')
                ->references('id')
                ->on('grammar_learning_path')
                ->onDelete('CASCADE');
        });

        Schema::create('grammar_learning_path_question_answer', function(Blueprint $table){
            $table->id();
            $table->foreignId('question_id');
            $table->string('answer');
            $table->boolean('accept_typo')->default(true);
            $table->text('indication')->nullable();
            $table->timestamps();

            $table->foreign('question_id')
                ->references('id')
                ->on('grammar_learning_path_questions')
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
        Schema::table('grammar_learning_path_question_answer', function(Blueprint $table){
            $table->dropForeign(['question_id']);
        });
        Schema::dropIfExists('grammar_learning_path_question_answer');

        Schema::table('grammar_learning_path_questions', function(Blueprint $table){
            $table->dropForeign(['grammar_item_id']);
        });
        Schema::dropIfExists('grammar_learning_path_questions');
    }
}
