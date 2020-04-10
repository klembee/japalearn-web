<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToVocabulary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('word_types', function(Blueprint $table){
            $table->id();
            $table->string('name');
        });

        Schema::table('vocabularies', function (Blueprint $table) {
            $table->foreignId('word_type_id')->nullable();

            $table->foreign('word_type_id')
                ->references('id')
                ->on('word_types')
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
        Schema::table('vocabularies', function(Blueprint $table){
            $table->dropForeign(['word_type_id']);
        });

        Schema::dropIfExists('word_types');
        Schema::table('vocabularies', function (Blueprint $table) {
            $table->dropColumn('word_type_id');
        });
    }
}
