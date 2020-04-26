<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrammarLearningPathTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grammar_learning_path_categories', function(Blueprint $table){
            $table->id();
            $table->string('category');
            $table->smallInteger('order')->default(0);
            $table->timestamps();
        });

        Schema::create('grammar_learning_path', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->longText('content');
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('grammar_learning_path_categories')
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
        Schema::table('grammar_learning_path', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        Schema::dropIfExists('grammar_learning_path_categories');
        Schema::dropIfExists('grammar_learning_path');
    }
}
