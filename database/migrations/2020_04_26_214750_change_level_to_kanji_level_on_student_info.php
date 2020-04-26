<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeLevelToKanjiLevelOnStudentInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_info', function (Blueprint $table) {
            $table->renameColumn('level', 'kanji_level');
            $table->integer('grammar_level')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_info', function (Blueprint $table) {
            $table->renameColumn('kanji_level', 'level');
            $table->dropColumn('grammar_level');
        });
    }
}
