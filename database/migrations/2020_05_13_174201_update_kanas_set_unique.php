<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateKanasSetUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kanas', function(Blueprint $table){
            $table->string('kana')->collation('utf8mb4_0900_bin')->change();
            $table->unique('kana');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kanas', function(Blueprint $table){
            $table->string('kana')->collation('utf8mb4_unicode_ci')->change();
            $table->dropUnique(['kana']);
        });
    }
}
