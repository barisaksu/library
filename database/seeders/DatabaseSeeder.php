<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        $this->call(MemberSeeder::class);
        $this->call(AuthorSeeder::class);
        //$this->call(PublisherSeeder::class);
        //$this->call(BlockSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(BookSeeder::class);
        $this->call(AdminSeeder::class);
    }
}
