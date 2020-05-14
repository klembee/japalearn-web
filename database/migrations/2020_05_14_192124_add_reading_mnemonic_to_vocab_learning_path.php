<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReadingMnemonicToVocabLearningPath extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vocab_learning_path', function (Blueprint $table) {
            $table->text('reading_mnemonic')->nullable();
            $table->renameColumn('mnemonic', 'meaning_mnemonic');
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
            $table->dropColumn('reading_mnemonic');
            $table->renameColumn('meaning_mnemonic', 'mnemonic');
        });
    }
}
