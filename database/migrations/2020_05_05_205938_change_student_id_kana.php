<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStudentIdKana extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kana_student', function(Blueprint $table){
            $table->dropForeign(['student_id']);
            $table->renameColumn('student_id', 'student_info_id');

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
        Schema::table('kana_student', function(Blueprint $table){

            $table->dropForeign(['student_info_id']);

            $table->renameColumn('student_info_id', 'student_id');

            $table->foreign('student_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');
        });
    }
}
