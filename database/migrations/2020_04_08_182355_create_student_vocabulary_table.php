<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentVocabularyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_vocabulary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id');
            $table->foreignId('vocabulary_id');
            $table->dateTime('last_studied')->nullable();
            $table->unsignedSmallInteger('level')->default(0);
            $table->timestamps();

            $table->unique(['student_id', 'vocabulary_id']);

            $table->foreign('student_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->foreign('vocabulary_id')
                ->references('id')
                ->on('vocabularies')
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
        Schema::table('student_vocabulary', function(Blueprint $table){
            $table->dropForeign(['student_id']);
            $table->dropForeign(['vocabulary_id']);
        });
        Schema::dropIfExists('student_vocabulary');
    }
}
