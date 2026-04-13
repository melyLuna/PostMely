<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
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
                'password' => bcrypt('mely123')
            ]
        );

        Category::factory(5)->create();
        Post::factory(15)->create();
        Tag::create(['name' => 'Laravel', 'slug' => 'laravel']);
        Tag::create(['name' => 'PHP', 'slug' => 'php']);
        Tag::create(['name' => 'Diseño', 'slug' => 'diseno']);
    }
}
