<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique();
            $table->bigInteger('information_id', false, true);
            $table->string('information_type');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');
        });

        Schema::table('student_info', function(Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('teacher_info', function(Blueprint $table){
            $table->dropForeign(['teacher_id']);
            $table->dropColumn('teacher_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_info', function(Blueprint $table){
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('user_info');

        Schema::table('student_info', function(Blueprint $table){
            $table->integer('user_id');
        });

        Schema::table('teacher_info', function(Blueprint $table){
            $table->integer('teacher_id');
        });


    }
}
