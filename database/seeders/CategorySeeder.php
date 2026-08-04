<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Mshua', 'Watoto', 'Bimkubwa',  'Za wote', 'ndugu', 'za kitambo', 'mkoani', 'graduation'];
        $personalCategories = ['girlfriend', 'pisi', 'makeup',  'wigs', 'cars', 'wwe', 'movies', 'babes', 'nyash', 'gym', 'cappucino', 'vacation'];
        $users = User::all();

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'uuid' => fake()->uuid()
            ]);
        }

        for ($i = 0; $i < 7; $i++) {//HIZI NI CATEGORY ZA KILA USER KIVYAKE VYAKE
            foreach ($users as $user) {
                $user->categories()->create([
                    'name' => fake()->randomElement($personalCategories),
                    'uuid' => fake()->uuid()
                ]);
            }
        }
    }
}
