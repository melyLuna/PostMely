<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence();
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => $this->faker->paragraph(2),
            'content' => $this->faker->text(1000),
            'img_path' => 'posts/'.$this->faker->image(null, 640, 480, 'animals', false),
            'user_id' => User::all()->random()->id,
            'category_id' => Category::all()->random()->id,
            'is_published' => $this->faker->boolean(80),
            'published_at' => now(),
        ];
    }
}
