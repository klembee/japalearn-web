<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaDescriptionToGrammarStoriesBlog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grammar_learning_path', function (Blueprint $table) {
            $table->string('meta_description')->nullable();
        });

        Schema::table('stories', function (Blueprint $table) {
            $table->string('meta_description')->nullable();
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->string('meta_description')->nullable();
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
            $table->dropColumn('meta_description');
        });

        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn('meta_description');
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn('meta_description');
        });
    }
}
