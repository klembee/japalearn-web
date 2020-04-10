<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLevelToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_info', function(Blueprint $table){
            $table->id();
            $table->foreignId('user_id');
            $table->integer('level', false, true)->default(0);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('student_info_id')->nullable();

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
        Schema::table('student_info', function(Blueprint $table){
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('student_info');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['student_info_id']);
            $table->dropColumn('student_info_id');
        });
    }
}
