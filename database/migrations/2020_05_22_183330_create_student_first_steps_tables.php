<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentFirstStepsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_first_steps', function (Blueprint $table) {
            $table->id();
            $table->string('step');
            $table->timestamps();
        });

        Schema::create('student_first_steps', function(Blueprint $table){
            $table->id();
            $table->foreignId('student_info_id')
                ->references('id')
                ->on('student_info')
                ->onDelete('CASCADE');
            $table->foreignId('first_step_id')
                ->references('id')
                ->on('account_first_steps')
                ->onDelete('CASCADE');
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
        Schema::table('student_first_steps', function(Blueprint $table){
            $table->dropForeign(['student_info_id']);
            $table->dropForeign(['first_step_id']);
        });
        Schema::dropIfExists('student_first_steps');

        Schema::dropIfExists('account_first_steps');
    }
}
