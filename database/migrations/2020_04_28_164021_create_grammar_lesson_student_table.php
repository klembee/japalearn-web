<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrammarLessonStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grammar_lesson_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grammar_item_id');
            $table->foreignId('student_info_id');
            $table->dateTime('date_done');
            $table->timestamps();

            $table->foreign('grammar_item_id')
                ->references('id')
                ->on('grammar_learning_path')
                ->onDelete('CASCADE');

            $table->foreign('student_info_id')
                ->references('id')
                ->on('student_info')
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
        Schema::table('grammar_lesson_student', function(Blueprint $table){
            $table->dropForeign(['student_info_id']);
            $table->dropForeign(['grammar_item_id']);
        });
        Schema::dropIfExists('grammar_lesson_student');
    }
}
