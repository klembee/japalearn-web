<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameVocabStudentLastRightToLastStudy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vocab_learning_path_item_student', function (Blueprint $table) {
            $table->renameColumn('writing_last_right_date', 'writing_last_study_date');
            $table->renameColumn('meaning_last_right_date', 'meaning_last_study_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vocab_learning_path_item_student', function (Blueprint $table) {
            $table->renameColumn('writing_last_study_date', 'writing_last_right_date');
            $table->renameColumn('meaning_last_study_date', 'meaning_last_right_date');
        });
    }
}
