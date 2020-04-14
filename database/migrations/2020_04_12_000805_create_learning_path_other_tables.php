<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningPathOtherTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('vocab_learning_path_answers', function(Blueprint $table){
//            $table->id();
//            $table->foreignId('vocab_learning_path_item_id');
//            $table->string('answer');
//            $table->timestamps();
//
//            $table->foreign('vocab_learning_path_item_id')
//                ->references('id')
//                ->on('vocab_learning_path')
//                ->onDelete('CASCADE');
//        });

        Schema::create('vocab_learning_path_meanings', function(Blueprint $table){
            $table->id();
            $table->foreignId('vocab_learning_path_item_id');
            $table->string('meaning');
            $table->timestamps();

            $table->foreign('vocab_learning_path_item_id')
                ->references('id')
                ->on('vocab_learning_path')
                ->onDelete('CASCADE');
        });

        Schema::create('vocab_learning_path_readings', function(Blueprint $table){
            $table->id();
            $table->foreignId('vocab_learning_path_item_id');
            $table->string('reading');
            $table->timestamps();

            $table->foreign('vocab_learning_path_item_id')
                ->references('id')
                ->on('vocab_learning_path')
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
//        Schema::table('vocab_learning_path_answers', function(Blueprint $table){
//            $table->dropForeign(['vocab_learning_path_item_id']);
//        });
//        Schema::table('vocab_learning_path_meanings', function(Blueprint $table){
//            $table->dropForeign(['vocab_learning_path_item_id']);
//        });
//        Schema::table('vocab_leaning_path_readings', function(Blueprint $table){
//            $table->dropForeign(['vocab_learning_path_item_id']);
//        });

//        Schema::dropIfExists('vocab_learning_path_answers');
        Schema::dropIfExists('vocab_learning_path_meanings');
        Schema::dropIfExists('vocab_learning_path_readings');
    }
}
