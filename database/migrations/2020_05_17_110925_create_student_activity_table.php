<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_types', function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('student_activity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_info_id')
                ->references('id')
                ->on('student_info')
                ->onDelete('CASCADE');

            $table->foreignId('activity_type_id')
                ->references('id')
                ->on('activity_types')
                ->onDelete('CASCADE');

            $table->integer('nb_items', false, true)->default(1);

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
        Schema::table('student_activity', function(Blueprint $table){
            $table->dropForeign(['student_info_id']);
            $table->dropForeign(['activity_type_id']);
        });
        Schema::dropIfExists('student_activity');
        Schema::dropIfExists('activity_types');
    }
}
