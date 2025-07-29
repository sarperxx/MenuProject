<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test_user@example.com',
            'is_admin' => true,
        ]);

        // Run all the menu-related seeders
        $this->call([
            MenuSeeder::class,
            MenuCategorySeeder::class,
            MenuItemSeeder::class,
            AllergenSeeder::class,
            CategoryMenuSeeder::class,
        ]);
    }
}
