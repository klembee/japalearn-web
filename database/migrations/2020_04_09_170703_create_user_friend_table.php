<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFriendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_friend', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('friend_id');
            $table->timestamps();

            $table->unique(['user_id', 'friend_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->foreign('friend_id')
                ->references('id')
                ->on('users')
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
        Schema::table('user_friend', function(Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropForeign(['friend_id']);
        });
        Schema::dropIfExists('user_friend');
    }
}
