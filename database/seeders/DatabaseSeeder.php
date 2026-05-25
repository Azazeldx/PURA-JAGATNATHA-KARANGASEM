<?php

namespace Database\Seeders;

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
        // Create User Command
        // php artisan filament:make-user
        // php artisan shield:super-admin
        
        $this->call([
            InitialSeeder::class,
        ]);
    }
}
