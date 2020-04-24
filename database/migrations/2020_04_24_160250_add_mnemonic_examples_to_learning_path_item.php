<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMnemonicExamplesToLearningPathItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vocab_learning_path_examples', function(Blueprint $table){
            $table->id();
            $table->foreignId('vocab_learning_path_item_id');

            $table->string('example');
            $table->string('translation');

            $table->timestamps();

            $table->foreign('vocab_learning_path_item_id')
                ->references('id')
                ->on('vocab_learning_path')
                ->onDelete('CASCADE');
        });

        Schema::table('vocab_learning_path', function (Blueprint $table) {
            $table->text('mnemonic')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vocab_learning_path_examples', function(Blueprint $table){
            $table->dropForeign(['vocab_learning_path_item_id']);
        });
        Schema::dropIfExists('vocab_learning_path_examples');

        Schema::table('vocab_learning_path', function (Blueprint $table) {
            $table->dropColumn('mnemonic');
        });
    }
}
