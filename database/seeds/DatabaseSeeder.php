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
         $this->call(UserSeeder::class);
         $this->call(RoleSeeder::class);
         $this->call(UserRoleSeeder::class);
         $this->call(ContactSeeder::class);
         $this->call(CategorySeeder::class);
         $this->call(ArticleSeeder::class);
         $this->call(CountrySeeder::class);
         $this->call(StatusSeeder::class);
         $this->call(TaskSeeder::class);
    }
}
