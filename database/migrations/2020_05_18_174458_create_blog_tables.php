<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('image_url')->nullable();
            $table->foreignId('author_id')->nullable();
            $table->timestamps();

            $table->foreign('author_id')
                ->references('id')
                ->on('authors')
                ->onDelete('SET NULL');
        });

        Schema::create('blog_post_comment', function(Blueprint $table){
            $table->id();
            $table->foreignId('blog_post_id')
                ->references('id')
                ->on('blog_posts')
                ->onDelete('CASCADE');
            $table->string('author_email');
            $table->string('author_name');
            $table->text('comment');
            $table->timestamps();
        });

        Schema::create('blog_post_keyword', function(Blueprint $table){
            $table->id();
            $table->foreignId('blog_post_id')
                ->references('id')
                ->on('blog_posts')
                ->onDelete('CASCADE');
            $table->string('keyword');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_post_keyword', function(Blueprint $table){
            $table->dropForeign(['blog_post_id']);
        });
        Schema::dropIfExists('blog_post_keyword');

        Schema::table('blog_post_comment', function(Blueprint $table){
            $table->dropForeign(['blog_post_id']) ;
        });
        Schema::dropIfExists('blog_post_comment');

        Schema::dropIfExists('blog_posts');
    }
}
