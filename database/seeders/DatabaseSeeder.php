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
        \App\Models\User::factory(300)->create();

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

        \App\Models\Action::factory(2000)->create();

        \App\Models\Like::factory(10000)->create();
    }
}
