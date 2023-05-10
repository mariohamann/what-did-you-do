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
        \App\Models\User::factory(30)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User 1',
            'email' => 'test1@example.com',
            'password' => bcrypt('!password'),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'password' => bcrypt('!password'),
        ]);

        \App\Models\Action::factory(200)->create();

        \App\Models\Like::factory(1000)->create();
    }
}
