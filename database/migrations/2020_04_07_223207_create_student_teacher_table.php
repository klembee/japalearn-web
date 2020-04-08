<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_teacher', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id');
            $table->foreignId('student_id');
            $table->timestamps();

            $table->foreign('teacher_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->foreign('student_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->unique(['teacher_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_teacher', function(Blueprint $table){
            $table->dropForeign(['teacher_id']);
            $table->dropForeign(['student_id']);
        });
        Schema::dropIfExists('student_teacher');
    }
}
