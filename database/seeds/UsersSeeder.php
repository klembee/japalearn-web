<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class UsersSeeder
 * Create the default users
 */
class UsersSeeder extends \Illuminate\Database\Seeder
{

    public function run(){
        // Create an admin user
        try {
            DB::table('users')->insert([
                'name' => "Clement Bisaillon",
                "email" => "admin@japalearn.com",
                "password" => \Illuminate\Support\Facades\Hash::make("snTK*st0KG2K"),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'role_id' => \App\Models\Role::admin()->id
            ]);

        }catch (\Illuminate\Database\QueryException $error){
            print("User already exist !\n");
        }

        // Create an teacher user
        try {
            DB::table('users')->insert([
                'name' => "The teacher",
                "email" => "teacher@japalearn.com",
                "password" => \Illuminate\Support\Facades\Hash::make("snTK*st0KG2K"),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'role_id' => \App\Models\Role::teacher()->id
            ]);

        }catch (\Illuminate\Database\QueryException $error){
            print("User already exist !\n");
        }

        // Create an student user
        try {
            DB::table('users')->insert([
                'name' => "The student",
                "email" => "student@japalearn.com",
                "password" => \Illuminate\Support\Facades\Hash::make("snTK*st0KG2K"),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'role_id' => \App\Models\Role::student()->id
            ]);

        }catch (\Illuminate\Database\QueryException $error){
            print("User already exist !\n");
        }

        // Create an moderator user
        try {
            DB::table('users')->insert([
                'name' => "The moderator",
                "email" => "moderator@japalearn.com",
                "password" => \Illuminate\Support\Facades\Hash::make("snTK*st0KG2K"),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'role_id' => \App\Models\Role::moderator()->id
            ]);

        }catch (\Illuminate\Database\QueryException $error){
            print("User already exist !\n");
        }
    }
}
