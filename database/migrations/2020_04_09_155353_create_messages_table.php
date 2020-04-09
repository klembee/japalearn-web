<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_id');
            $table->foreignId('to_id');
            $table->text('message');
            $table->boolean('read')->default(false);
            $table->timestamps();

            $table->foreign('from_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->foreign('to_id')
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
        Schema::table('messages', function(Blueprint $table){
            $table->dropForeign(['from_id']);
            $table->dropForeign(['to_id']);
        });

        Schema::dropIfExists('messages');
    }
}
