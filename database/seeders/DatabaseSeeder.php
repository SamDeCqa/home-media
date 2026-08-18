<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $this->call([
        UserSeeder::class,
        RoleSeeder::class,
        CategorySeeder::class,
        TagSeeder::class,
        MediaSeeder::class,
        MediaTagSeeder::class,
        MediaCategorySeeder::class
       ]);
    }
}
