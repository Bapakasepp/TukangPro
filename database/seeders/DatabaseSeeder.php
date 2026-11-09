<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@tukangpro.id'],
            [
                'name' => 'Admin NOC TukangPro',
                'password' => Hash::make('password'),
            ]
        );

        $this->call([
            ServiceCategorySeeder::class,
            TechnicianSeeder::class,
            ServiceOrderSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}