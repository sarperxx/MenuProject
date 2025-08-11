<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Allergen;
use App\Models\MenuItem;

class AllergenSeeder extends Seeder
{
    public function run(): void
    {
        $allergens = [
            'Gluten',
            'Peanuts',
            'Lactose',
            'Eggs',
            'Soy',
        ];

        $allergenIds = [];
        foreach ($allergens as $name) {
            $allergen = Allergen::firstOrCreate(['name' => $name]);
            $allergenIds[] = $allergen->id;
        }

        // Randomly assign allergens to menu items
        $menuItems = MenuItem::all();
        foreach ($menuItems as $item) {
            // Assign 0-3 random allergens to each item
            $randomAllergens = collect($allergenIds)->shuffle()->take(rand(0, 3))->all();
            $item->allergens()->sync($randomAllergens);
        }
    }
}
