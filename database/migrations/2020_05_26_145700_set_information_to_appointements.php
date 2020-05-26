<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetInformationToAppointements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropForeign(['student_id']);
            $table->renameColumn('student_id', 'student_info_id');
            $table->renameColumn('teacher_id', 'teacher_info_id');

            $table->foreign('student_info_id')
                ->references('id')
                ->on('student_info')
                ->onDelete('CASCADE');

            $table->foreign('teacher_info_id')
                ->references('id')
                ->on('teacher_info')
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
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['teacher_info_id']);
            $table->dropForeign(['student_info_id']);

            $table->renameColumn('student_info_id', 'student_id');
            $table->renameColumn('teacher_info_id', 'teacher_id');

            $table->foreign('student_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->foreign('teacher_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');
        });
    }
}
