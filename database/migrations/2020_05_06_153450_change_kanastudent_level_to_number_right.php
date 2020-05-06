<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeKanastudentLevelToNumberRight extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kana_student', function (Blueprint $table) {
            $table->renameColumn('level', 'number_right');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kana_student', function (Blueprint $table) {
            $table->renameColumn('number_right', 'level');
        });
    }
}
