<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\MediaTag;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MediaTag>
 */
class MediaTagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tag_id' => Tag::inRandomOrder()->value('id'),
            'media_id' => Media::inRandomOrder()->value('id'),
        ];
    }
}
