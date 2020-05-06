<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('content');
            $table->string('keywords')->nullable();
            $table->string('front_image_url')->nullable();
            $table->timestamps();
        });

        Schema::create('story_question', function(Blueprint $table){
            $table->id();
            $table->foreignId('story_id');
            $table->string('question');
            $table->timestamps();

            $table->foreign('story_id')
                ->references('id')
                ->on('stories')
                ->onDelete('cascade');
        });

        Schema::create('story_question_answer', function(Blueprint $table){
            $table->id();
            $table->foreignId('question_id');
            $table->string('answer');
            $table->timestamps();

            $table->foreign('question_id')
                ->references('id')
                ->on('story_question')
                ->onDelete('CASCADE');
        });

        Schema::create('story_student', function(Blueprint $table){
            $table->id();
            $table->foreignId('student_id');
            $table->foreignId('story_id');
            $table->dateTime('read_on');
            $table->timestamps();

            $table->foreign('student_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->foreign('story_id')
                ->references('id')
                ->on('stories')
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
        Schema::table('story_student', function(Blueprint $table){
            $table->dropForeign(['student_id']);
            $table->dropForeign(['story_id']);
        });
        Schema::dropIfExists('story_student');

        Schema::table('story_question_answer', function(Blueprint $table){
            $table->dropForeign(['question_id']);
        });
        Schema::dropIfExists('story_question_answer');

        Schema::table('story_question', function(Blueprint $table){
            $table->dropForeign(['story_id']);
        });
        Schema::dropIfExists('story_question');

        Schema::dropIfExists('stories');
    }
}
