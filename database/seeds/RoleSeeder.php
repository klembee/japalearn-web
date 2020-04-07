<?php

use Illuminate\Support\Facades\DB;


/**
 * Class RoleSeeder
 * Create the default roles of the application
 */
class RoleSeeder extends \Illuminate\Database\Seeder
{
    public function run(){

        $roles = [
            "admin",
            "moderator",
            "teacher",
            "student"
        ];

        foreach($roles as $role){
            try{
                DB::table('roles')->insert([
                    'name' => $role
                ]);
            }catch (\Illuminate\Database\QueryException $error){
                print("Role already exist !\n");
            }

        }
    }
}
