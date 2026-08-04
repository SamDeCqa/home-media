<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = ['TBT', 'To_Be_Missed', 'family', 'utoto', 'fun', 'love', 'education', 'barcelona', 'simba', 'yanga', 'tech'];
        $users = User::all();

        foreach ($users as $user) {
            $user->tags()->create([
                'name' => fake()->word(),
                'uuid' => fake()->uuid()
            ]);
        }

        for ($i = 0; $i < 5; $i++) { //HIZI NI CATEGORY ZA KILA USER KIVYAKE VYAKE
            foreach ($tags as $tag) {
                Tag::create([
                    'name' => $tag,
                    'uuid' => fake()->uuid()
                ]);
            }
        }
    }
}
