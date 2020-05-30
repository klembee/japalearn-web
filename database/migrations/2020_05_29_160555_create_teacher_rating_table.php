<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_info_id')
                ->references('id')
                ->on('teacher_info')
                ->onDelete('CASCADE');

            $table->foreignId('student_info_id')->nullable()
                ->references('id')
                ->on('student_info')
                ->onDelete('SET NULL');

            $table->smallInteger('rating', false, true);
            $table->text('comment')->nullable();

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
        Schema::table('teacher_ratings', function(Blueprint $table){
            $table->dropForeign(['teacher_info_id']);
            $table->dropForeign(['student_info_id']);
        });

        Schema::dropIfExists('teacher_rating');
    }
}
