<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_preferences', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('email_preference_user', function(Blueprint $table){
            $table->id();
            $table->foreignId('preference_id')
                ->references('id')
                ->on('email_preferences')
                ->onDelete('CASCADE');
            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
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
        Schema::table('email_preference_user', function(Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropForeign(['preference_id']);
        });
        Schema::dropIfExists('email_preference_user');
        Schema::dropIfExists('email_preferences');
    }
}
