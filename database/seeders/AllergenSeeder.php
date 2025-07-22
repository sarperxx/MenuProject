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

        foreach ($allergens as $name) {
            Allergen::create(['name' => $name]);
        }

        // Örnek ilişkilendirme: bazı yemeklere alerjen bağlayalım
      
    }
}
