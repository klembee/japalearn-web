<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionToTeacherInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teacher_info', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->boolean('offer_free_trial')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teacher_info', function (Blueprint $table) {
            Schema::table('teacher_info', function (Blueprint $table) {
                $table->dropColumn(['description', 'offer_free_trial']);
            });
        });
    }
}
