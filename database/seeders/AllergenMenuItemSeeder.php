<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;
use App\Models\Allergen;

class AllergenMenuItemSeeder extends Seeder
{
    public function run(): void
    {
        // Get all allergens
        $gluten = Allergen::where('name', 'Gluten')->first();
        $peanuts = Allergen::where('name', 'Peanuts')->first();
        $lactose = Allergen::where('name', 'Lactose')->first();
        $eggs = Allergen::where('name', 'Eggs')->first();
        $soy = Allergen::where('name', 'Soy')->first();

        // Assign allergens to menu items
        $this->assignAllergensToItems($gluten, $peanuts, $lactose, $eggs, $soy);
    }

    private function assignAllergensToItems($gluten, $peanuts, $lactose, $eggs, $soy)
    {
        // Appetizers
        $bruschetta = MenuItem::where('name', 'Bruschetta')->first();
        if ($bruschetta) {
            $bruschetta->allergens()->attach([$gluten->id, $eggs->id]);
        }

        $mozzarellaSticks = MenuItem::where('name', 'Mozzarella Sticks')->first();
        if ($mozzarellaSticks) {
            $mozzarellaSticks->allergens()->attach([$gluten->id, $lactose->id, $eggs->id]);
        }

        // Soups
        $tomatoSoup = MenuItem::where('name', 'Tomato Basil Soup')->first();
        if ($tomatoSoup) {
            $tomatoSoup->allergens()->attach([$lactose->id]);
        }

        $chickenSoup = MenuItem::where('name', 'Chicken Noodle Soup')->first();
        if ($chickenSoup) {
            $chickenSoup->allergens()->attach([$gluten->id]);
        }

        // Salads
        $caesarSalad = MenuItem::where('name', 'Caesar Salad')->first();
        if ($caesarSalad) {
            $caesarSalad->allergens()->attach([$gluten->id, $eggs->id, $lactose->id]);
        }

        $greekSalad = MenuItem::where('name', 'Greek Salad')->first();
        if ($greekSalad) {
            $greekSalad->allergens()->attach([$lactose->id]);
        }

        // Main Courses
        $salmon = MenuItem::where('name', 'Grilled Salmon')->first();
        if ($salmon) {
            $salmon->allergens()->attach([$soy->id]);
        }

        $beefTenderloin = MenuItem::where('name', 'Beef Tenderloin')->first();
        if ($beefTenderloin) {
            $beefTenderloin->allergens()->attach([$gluten->id, $lactose->id]);
        }

        $chickenMarsala = MenuItem::where('name', 'Chicken Marsala')->first();
        if ($chickenMarsala) {
            $chickenMarsala->allergens()->attach([$gluten->id, $eggs->id]);
        }

        // Desserts
        $tiramisu = MenuItem::where('name', 'Tiramisu')->first();
        if ($tiramisu) {
            $tiramisu->allergens()->attach([$gluten->id, $eggs->id, $lactose->id]);
        }

        $lavaCake = MenuItem::where('name', 'Chocolate Lava Cake')->first();
        if ($lavaCake) {
            $lavaCake->allergens()->attach([$gluten->id, $eggs->id, $lactose->id]);
        }

        // Hot Beverages
        $espresso = MenuItem::where('name', 'Espresso')->first();
        if ($espresso) {
            // Espresso typically has no allergens
        }

        $cappuccino = MenuItem::where('name', 'Cappuccino')->first();
        if ($cappuccino) {
            $cappuccino->allergens()->attach([$lactose->id]);
        }

        $hotTea = MenuItem::where('name', 'Hot Tea')->first();
        if ($hotTea) {
            // Tea typically has no allergens
        }

        // Cold Beverages
        $icedCoffee = MenuItem::where('name', 'Iced Coffee')->first();
        if ($icedCoffee) {
            // Iced coffee typically has no allergens
        }

        $lemonade = MenuItem::where('name', 'Lemonade')->first();
        if ($lemonade) {
            // Lemonade typically has no allergens
        }

        // Cocktails
        $mojito = MenuItem::where('name', 'Mojito')->first();
        if ($mojito) {
            // Mojito typically has no allergens
        }

        $margarita = MenuItem::where('name', 'Margarita')->first();
        if ($margarita) {
            // Margarita typically has no allergens
        }

        // Breakfast Items
        $pastries = MenuItem::where('name', 'Assorted Pastries')->first();
        if ($pastries) {
            $pastries->allergens()->attach([$gluten->id, $eggs->id, $lactose->id]);
        }

        $fruitPlate = MenuItem::where('name', 'Fresh Fruit Plate')->first();
        if ($fruitPlate) {
            $fruitPlate->allergens()->attach([$lactose->id]);
        }

        $eggsBenedict = MenuItem::where('name', 'Eggs Benedict')->first();
        if ($eggsBenedict) {
            $eggsBenedict->allergens()->attach([$gluten->id, $eggs->id, $lactose->id]);
        }

        $waffles = MenuItem::where('name', 'Belgian Waffles')->first();
        if ($waffles) {
            $waffles->allergens()->attach([$gluten->id, $eggs->id, $lactose->id]);
        }

        // Premium Items
        $arancini = MenuItem::where('name', 'Truffle Arancini')->first();
        if ($arancini) {
            $arancini->allergens()->attach([$gluten->id, $eggs->id, $lactose->id]);
        }

        $lobsterBisque = MenuItem::where('name', 'Lobster Bisque')->first();
        if ($lobsterBisque) {
            $lobsterBisque->allergens()->attach([$gluten->id, $lactose->id]);
        }

        $wagyuBeef = MenuItem::where('name', 'Wagyu Beef Steak')->first();
        if ($wagyuBeef) {
            $wagyuBeef->allergens()->attach([$soy->id]);
        }

        $lobsterThermidor = MenuItem::where('name', 'Lobster Thermidor')->first();
        if ($lobsterThermidor) {
            $lobsterThermidor->allergens()->attach([$gluten->id, $eggs->id, $lactose->id]);
        }

        // Room Service Items
        $clubSandwich = MenuItem::where('name', 'Club Sandwich')->first();
        if ($clubSandwich) {
            $clubSandwich->allergens()->attach([$gluten->id, $eggs->id]);
        }

        $roomServiceCaesar = MenuItem::where('name', 'Caesar Salad')->where('price', 13.50)->first();
        if ($roomServiceCaesar) {
            $roomServiceCaesar->allergens()->attach([$gluten->id, $eggs->id, $lactose->id]);
        }

        $nachos = MenuItem::where('name', 'Loaded Nachos')->first();
        if ($nachos) {
            $nachos->allergens()->attach([$lactose->id]);
        }

        $wings = MenuItem::where('name', 'Chicken Wings')->first();
        if ($wings) {
            $wings->allergens()->attach([$gluten->id, $soy->id]);
        }

        // Snack Items
        $hummus = MenuItem::where('name', 'Hummus & Pita')->first();
        if ($hummus) {
            $hummus->allergens()->attach([$gluten->id]);
        }

        $capreseSkewers = MenuItem::where('name', 'Caprese Skewers')->first();
        if ($capreseSkewers) {
            $capreseSkewers->allergens()->attach([$lactose->id]);
        }

        $cookies = MenuItem::where('name', 'Chocolate Chip Cookies')->first();
        if ($cookies) {
            $cookies->allergens()->attach([$gluten->id, $eggs->id, $lactose->id]);
        }

        $sundae = MenuItem::where('name', 'Ice Cream Sundae')->first();
        if ($sundae) {
            $sundae->allergens()->attach([$lactose->id, $peanuts->id]);
        }

        $this->command->info('Allergens assigned to menu items successfully!');
    }
}
