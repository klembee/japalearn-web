<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVocabLearningPathItemUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vocab_learning_path_item_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_path_item_id');
            $table->foreignId('student_info_id');
            $table->integer('writing_right', false, true)->default(0);
            $table->integer('meaning_right', false, true)->default(0);
            $table->dateTime('writing_last_right_date')->nullable();
            $table->dateTime('meaning_last_right_date')->nullable();
            $table->timestamps();

            $table->foreign('learning_path_item_id')
                ->references('id')
                ->on('vocab_learning_path')
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
        Schema::table('vocab_learning_path_item_student', function(Blueprint $table){
            $table->dropForeign(['learning_path_item_id']);
            $table->dropForeign(['student_info_id']);
        });
        Schema::dropIfExists('vocab_learning_path_item_student');
    }
}
