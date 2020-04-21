<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id');
            $table->string('week_day');
            $table->time('hour');
            $table->timestamps();

            $table->unique(['teacher_id', 'week_day', 'hour']);

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
        Schema::table('teacher_availabilities', function(Blueprint $table){
            $table->dropForeign(['teacher_id']);
        });

        Schema::dropIfExists('teacher_availabilities');
    }
}
