<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentInvitationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_invitation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id');
            $table->string('code')->unique();
            $table->timestamps();

            $table->foreign('teacher_id')
                ->references('id')
                ->on('users')
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
        Schema::table('student_invitation', function(Blueprint $table){
            $table->dropForeign(['teacher_id']);
        });
        Schema::dropIfExists('student_invitation');
    }
}
