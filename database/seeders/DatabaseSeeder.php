<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            [
            'name' => 'Mely',
            'email' => 'mely@example.com',
            'password'=>bcrypt('mely123')
        ]);

        Category::factory(5)->create();
        Post::factory(15)->create();

    }
}
