<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFrontImageUrlToGrammarItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grammar_learning_path', function (Blueprint $table) {
            $table->string('front_image_url')->nullable();
            $table->string('front_image_alt')->nullable();
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
            $table->dropColumn(['front_image_url', 'front_image_alt']);
        });
    }
}
