<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetGrammarLessonStudentUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grammar_lesson_student', function(Blueprint $table){
            $table->unique(['grammar_item_id', 'student_info_id']);
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
            $table->dropUnique(['grammar_item_id', 'student_info_id']);
        });
    }
}
