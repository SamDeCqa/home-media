<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Media;
use App\Models\MediaCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MediaCategory>
 */
class MediaCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'media_id' => Media::inRandomOrder()->value('id'),
            'category_id' => Category::inRandomOrder()->value('id'),
        ];
    }
}
