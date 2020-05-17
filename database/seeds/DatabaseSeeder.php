<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(RoleSeeder::class);
         $this->call(UsersSeeder::class);
         $this->call(WordTypeSeeder::class);
         $this->call(KanaSeeder::class);
         $this->call(GrammarCategorySeeder::class);
         $this->call(RadicalsSeeder::class);
         $this->call(ActivityTypeSeeder::class);
    }
}
