<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        Schema::create('gift_document', function(Blueprint $table){
            $table->id();
            $table->foreignId('gift_id')
                ->references('id')
                ->on('gifts')
                ->onDelete('CASCADE');
            $table->string('document_path');
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
        Schema::table('gift_document', function(Blueprint $table){
            $table->dropForeign(['gift_id']);
        });
        Schema::dropIfExists('gift_document');

        Schema::dropIfExists('gifts');
    }
}
