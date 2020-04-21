<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id');
            $table->foreignId('student_id');
            $table->dateTime('date');
            $table->integer('duration_minute');
            $table->boolean('confirmed')->default(false);
            $table->integer('cost_total');
            $table->timestamps();

            $table->foreign('teacher_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->foreign('student_id')
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
        Schema::table('appointments', function(Blueprint $table){
            $table->dropForeign(['teacher_id']);
            $table->dropForeign(['student_id']);
        });

        Schema::dropIfExists('appointments');
    }
}
