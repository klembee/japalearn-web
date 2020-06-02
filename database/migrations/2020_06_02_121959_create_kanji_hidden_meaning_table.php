<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKanjiHiddenMeaningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kanji_alternative_meaning', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kanji_id')
                ->references('id')
                ->on('vocab_learning_path')
                ->onDelete('CASCADE');

            $table->string('meaning');
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
        Schema::table('kanji_alternative_meaning', function(Blueprint $table){
            $table->dropForeign(['kanji_id']);
        });
        Schema::dropIfExists('kanji_alternative_meaning');
    }
}
