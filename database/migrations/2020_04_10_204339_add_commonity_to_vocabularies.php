<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommonityToVocabularies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vocabularies', function (Blueprint $table) {
            $table->integer('commonity', false, true)->default(999);
        });

        Schema::table('vocabulary_meaning', function(Blueprint $table){
            $table->string('indication')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vocabularies', function (Blueprint $table) {
            $table->dropColumn('commonity');
        });

        Schema::table('vocabulary_meaning', function(Blueprint $table){
            $table->dropColumn('indication');
        });
    }
}
