<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveWritingLastRight extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vocab_learning_path_item_student', function(Blueprint $table){
            $table->dropColumn('writing_last_study_date');
            $table->dropColumn('meaning_right');
            $table->renameColumn('writing_right', 'nb_right');
            $table->renameColumn('meaning_last_study_date', 'last_study_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vocab_learning_path_item_student', function(Blueprint $table){
            $table->dateTime('writing_last_study_date')->nullable();
            $table->integer('meaning_right', false, true)->default(0);
            $table->renameColumn('nb_right', 'writing_right');
            $table->renameColumn('last_study_date', 'meaning_last_study_date');
        });
    }
}
