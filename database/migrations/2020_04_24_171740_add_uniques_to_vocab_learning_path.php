<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniquesToVocabLearningPath extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vocab_learning_path', function (Blueprint $table) {
            $table->unique(['level', 'word_type_id', 'word']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vocab_learning_path', function (Blueprint $table) {
            $table->dropUnique(['level', 'word_type_id', 'word']);
        });
    }
}
