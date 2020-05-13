<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeVocabLearningPathEncodingToUtf16 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vocab_learning_path', function (Blueprint $table) {
            $table->string('word')->charset('utf8mb4')->collation('utf8mb4_bin')->change();
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
            $table->string('word')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
        });
    }
}
