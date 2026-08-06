<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(rand(2,4), true),
            'uuid' => fake()->uuid(),
            'path' => fake()->filePath(),
            'content_type' => 'image/png',
            'description' => fake()->boolean(70) ? fake()->realText() : null,
            'is_favorite' => fake()->boolean(30),
            'user_id' => User::inRandomOrder()->value('id'),
            'is_private' => fake()->boolean(20),
            'category_id' => fake()->boolean(73) ? Category::inRandomOrder()->value('id') : null,
            'byte_size' => rand(589, 14896),
            ];
    }
}
