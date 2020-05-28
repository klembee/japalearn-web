<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('aws_meeting_id')->nullable();
            $table->string('region');
            $table->string("client_request_token");
            $table->timestamps();
        });

        Schema::create('meeting_user', function(Blueprint $table){
            $table->id();

            $table->foreignId('meeting_id')
                ->references('id')
                ->on('meetings')
                ->onDelete('CASCADE');

            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->string('aws_attendee_id');
            $table->string('token');

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
        Schema::table('meeting_user', function(Blueprint $table){
            $table->dropForeign(['meeting_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('meeting_user');

        Schema::dropIfExists('meetings');
    }
}
