<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SubscriberOnlyToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->boolean('subscriber_only')->default(true);
        });

        Schema::table('grammar_learning_path', function (Blueprint $table) {
            $table->boolean('subscriber_only')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn('subscriber_only');
        });

        Schema::table('grammar_learning_path', function (Blueprint $table) {
            $table->dropColumn('subscriber_only');
        });
    }
}
