<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kanas', function (Blueprint $table) {
            $table->id();
            $table->string('kana');
            $table->string('romaji');
            $table->text('mnemonic')->nullable();
            $table->timestamps();
        });

        Schema::create('kana_student', function(Blueprint $table){
            $table->id();
            $table->foreignId('student_id');
            $table->foreignId('kana_id');
            $table->smallInteger('level')->default(0);
            $table->dateTime('last_review');
            $table->timestamps();

            $table->unique(['student_id', 'kana_id']);

            $table->foreign('student_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->foreign('kana_id')
                ->references('id')
                ->on('kanas')
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
            $table->dropForeign(['kana_id']);
            $table->dropForeign(['student_id']);
        });

        Schema::dropIfExists('kana_student');

        Schema::dropIfExists('kanas');
    }
}
