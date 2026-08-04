<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'Baba',
            'Mama',
            'mimi',
            'dogo',
            'kaka',
            'dada',
            'shangazi',
            'rafiki wa dada'
        ];

        $roles = RolesEnum::cases();

        foreach ($names as $name) {
            User::create([
                'name' => $name,
                'password' => Hash::make('password'),
                'role' => fake()->randomElement($roles),
                'is_verified' => fake()->boolean(60),
                'uuid' => fake()->uuid()
            ]);
        }
    }
}
