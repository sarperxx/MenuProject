<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Menu;

class MenuCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing menus
        $dinnerMenu = Menu::where('slug', 'dinner-menu')->first();
        $drinkMenu = Menu::where('slug', 'drink-menu')->first();
        $breakfastMenu = Menu::where('slug', 'breakfast-menu')->first();
        $maseratiMenu = Menu::where('slug', 'maserati-menu')->first();
        $roomServiceMenu = Menu::where('slug', 'room-service-menu')->first();
        $snackMenu = Menu::where('slug', 'snack-menu')->first();

        // Dinner Menu Categories
        if ($dinnerMenu) {
            $dinnerCategories = [
                ['name' => 'Appetizers', 'position' => 1],
                ['name' => 'Soups', 'position' => 2],
                ['name' => 'Salads', 'position' => 3],
                ['name' => 'Main Courses', 'position' => 4],
                ['name' => 'Desserts', 'position' => 5],
                ['name' => 'Beverages', 'position' => 6],
            ];

            foreach ($dinnerCategories as $categoryData) {
                $category = Category::create($categoryData);
                $category->menus()->attach($dinnerMenu->id);
            }
        }

        // Drink Menu Categories
        if ($drinkMenu) {
            $drinkCategories = [
                ['name' => 'Hot Beverages', 'position' => 1],
                ['name' => 'Cold Beverages', 'position' => 2],
                ['name' => 'Alcoholic Drinks', 'position' => 3],
                ['name' => 'Cocktails', 'position' => 4],
                ['name' => 'Fresh Juices', 'position' => 5],
            ];

            foreach ($drinkCategories as $categoryData) {
                $category = Category::create($categoryData);
                $category->menus()->attach($drinkMenu->id);
            }
        }

        // Breakfast Menu Categories
        if ($breakfastMenu) {
            $breakfastCategories = [
                ['name' => 'Continental Breakfast', 'position' => 1],
                ['name' => 'Hot Breakfast', 'position' => 2],
                ['name' => 'Pastries & Breads', 'position' => 3],
                ['name' => 'Cereals & Yogurt', 'position' => 4],
                ['name' => 'Beverages', 'position' => 5],
            ];

            foreach ($breakfastCategories as $categoryData) {
                $category = Category::create($categoryData);
                $category->menus()->attach($breakfastMenu->id);
            }
        }

        // Maserati Menu Categories
        if ($maseratiMenu) {
            $maseratiCategories = [
                ['name' => 'Premium Appetizers', 'position' => 1],
                ['name' => 'Gourmet Entrees', 'position' => 2],
                ['name' => 'Fine Wines', 'position' => 3],
                ['name' => 'Craft Cocktails', 'position' => 4],
                ['name' => 'Artisan Desserts', 'position' => 5],
            ];

            foreach ($maseratiCategories as $categoryData) {
                $category = Category::create($categoryData);
                $category->menus()->attach($maseratiMenu->id);
            }
        }

        // Room Service Menu Categories
        if ($roomServiceMenu) {
            $roomServiceCategories = [
                ['name' => '24/7 Classics', 'position' => 1],
                ['name' => 'Late Night Bites', 'position' => 2],
                ['name' => 'Comfort Food', 'position' => 3],
                ['name' => 'Quick Snacks', 'position' => 4],
                ['name' => 'Beverages', 'position' => 5],
            ];

            foreach ($roomServiceCategories as $categoryData) {
                $category = Category::create($categoryData);
                $category->menus()->attach($roomServiceMenu->id);
            }
        }

        // Snack Menu Categories
        if ($snackMenu) {
            $snackCategories = [
                ['name' => 'Light Bites', 'position' => 1],
                ['name' => 'Finger Foods', 'position' => 2],
                ['name' => 'Sweet Treats', 'position' => 3],
                ['name' => 'Healthy Options', 'position' => 4],
                ['name' => 'Beverages', 'position' => 5],
            ];

            foreach ($snackCategories as $categoryData) {
                $category = Category::create($categoryData);
                $category->menus()->attach($snackMenu->id);
            }
        }

        $this->command->info('Menu categories seeded successfully!');
    }
}
