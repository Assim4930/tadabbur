<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * Kept clean for real production/registered users.
     */
    public function run(): void
    {
        // No demo users or quotes seeded; the platform is ready for real users.
    }
}
