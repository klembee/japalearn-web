<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeInformationMorphable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table){
            $table->bigInteger('information_id', false, true);
            $table->string('information_type');
        });

        foreach (\App\Models\UserInformation::all() as $info){
            $user = $info->user;
            $user->information_id = $info->information_id;
            $user->information_type = $info->information_type;
            $user->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table){
            $table->dropColumn(['information_id', 'information_type']);
        });
    }
}
