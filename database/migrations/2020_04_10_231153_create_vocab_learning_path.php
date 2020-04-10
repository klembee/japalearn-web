<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVocabLearningPath extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vocab_learning_path', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vocabulary_id');
            $table->integer("level", false, true)->default(0);
            $table->timestamps();

            $table->foreign('vocabulary_id')
                ->references('id')
                ->on('vocabularies')
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
        Schema::table('vocab_learning_path', function(Blueprint $table){
            $table->dropForeign(['vocabulary_id']);
        });
        Schema::dropIfExists('vocab_learning_path');
    }
}
