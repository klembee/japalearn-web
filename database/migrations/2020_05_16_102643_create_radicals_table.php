<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRadicalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radicals', function (Blueprint $table) {
            $table->id();
            $table->string('radical');
            $table->timestamps();
        });

        Schema::create("kanji_radical", function(Blueprint $table){
            $table->id();
            $table->foreignId('kanji_id')
                ->references('id')
                ->on('vocab_learning_path')
                ->onDelete('CASCADE');

            $table->foreignId('radical_id')
                ->references('id')
                ->on('radicals')
                ->onDelete('CASCADE');

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
        Schema::dropIfExists('radicals');

        Schema::table('kanji_radical', function(Blueprint $table){
            $table->dropForeign(['radical_id']);
            $table->dropForeign(['kanji_id']);
        });
        Schema::dropIfExists('kanji_radical');
    }
}
