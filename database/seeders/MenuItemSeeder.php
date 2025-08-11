<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;
use App\Models\Category;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        // Dinner Menu Items
        $appetizers = Category::where('name', 'Appetizers')->first();
        if ($appetizers) {
            MenuItem::insert([
                [
                    'name' => 'Bruschetta',
                    'description' => 'Toasted bread topped with tomatoes, garlic, and olive oil.',
                    'price' => 8.50,
                    'image' => null,
                    'category_id' => $appetizers->id,
                ],
                [
                    'name' => 'Mozzarella Sticks',
                    'description' => 'Crispy breaded mozzarella served with marinara sauce.',
                    'price' => 9.99,
                    'image' => null,
                    'category_id' => $appetizers->id,
                ],
            ]);
        }

        $soups = Category::where('name', 'Soups')->first();
        if ($soups) {
            MenuItem::insert([
                [
                    'name' => 'Tomato Basil Soup',
                    'description' => 'Creamy tomato soup with fresh basil.',
                    'price' => 7.50,
                    'image' => null,
                    'category_id' => $soups->id,
                ],
                [
                    'name' => 'Chicken Noodle Soup',
                    'description' => 'Homestyle chicken soup with vegetables.',
                    'price' => 8.00,
                    'image' => null,
                    'category_id' => $soups->id,
                ],
            ]);
        }

        $salads = Category::where('name', 'Salads')->first();
        if ($salads) {
            MenuItem::insert([
                [
                    'name' => 'Caesar Salad',
                    'description' => 'Romaine lettuce, croutons, parmesan, and Caesar dressing.',
                    'price' => 10.50,
                    'image' => null,
                    'category_id' => $salads->id,
                ],
                [
                    'name' => 'Greek Salad',
                    'description' => 'Fresh vegetables with feta cheese and olives.',
                    'price' => 11.00,
                    'image' => null,
                    'category_id' => $salads->id,
                ],
            ]);
        }

        $mainCourses = Category::where('name', 'Main Courses')->first();
        if ($mainCourses) {
            MenuItem::insert([
                [
                    'name' => 'Grilled Salmon',
                    'description' => 'Fresh salmon with seasonal vegetables.',
                    'price' => 24.99,
                    'image' => null,
                    'category_id' => $mainCourses->id,
                ],
                [
                    'name' => 'Beef Tenderloin',
                    'description' => '8oz tenderloin with garlic mashed potatoes.',
                    'price' => 28.50,
                    'image' => null,
                    'category_id' => $mainCourses->id,
                ],
                [
                    'name' => 'Chicken Marsala',
                    'description' => 'Pan-seared chicken in marsala wine sauce.',
                    'price' => 22.00,
                    'image' => null,
                    'category_id' => $mainCourses->id,
                ],
            ]);
        }

        $desserts = Category::where('name', 'Desserts')->first();
        if ($desserts) {
            MenuItem::insert([
                [
                    'name' => 'Tiramisu',
                    'description' => 'Classic Italian dessert with coffee and mascarpone.',
                    'price' => 9.50,
                    'image' => null,
                    'category_id' => $desserts->id,
                ],
                [
                    'name' => 'Chocolate Lava Cake',
                    'description' => 'Warm chocolate cake with molten center.',
                    'price' => 8.99,
                    'image' => null,
                    'category_id' => $desserts->id,
                ],
            ]);
        }

        // Drink Menu Items
        $hotBeverages = Category::where('name', 'Hot Beverages')->first();
        if ($hotBeverages) {
            MenuItem::insert([
                [
                    'name' => 'Espresso',
                    'description' => 'Single shot of premium coffee.',
                    'price' => 3.50,
                    'image' => null,
                    'category_id' => $hotBeverages->id,
                ],
                [
                    'name' => 'Cappuccino',
                    'description' => 'Espresso with steamed milk and foam.',
                    'price' => 4.50,
                    'image' => null,
                    'category_id' => $hotBeverages->id,
                ],
                [
                    'name' => 'Hot Tea',
                    'description' => 'Selection of premium teas.',
                    'price' => 3.00,
                    'image' => null,
                    'category_id' => $hotBeverages->id,
                ],
            ]);
        }

        $coldBeverages = Category::where('name', 'Cold Beverages')->first();
        if ($coldBeverages) {
            MenuItem::insert([
                [
                    'name' => 'Iced Coffee',
                    'description' => 'Cold brewed coffee over ice.',
                    'price' => 4.00,
                    'image' => null,
                    'category_id' => $coldBeverages->id,
                ],
                [
                    'name' => 'Lemonade',
                    'description' => 'Fresh squeezed lemonade.',
                    'price' => 3.50,
                    'image' => null,
                    'category_id' => $coldBeverages->id,
                ],
            ]);
        }

        $cocktails = Category::where('name', 'Cocktails')->first();
        if ($cocktails) {
            MenuItem::insert([
                [
                    'name' => 'Mojito',
                    'description' => 'Rum, mint, lime, and soda.',
                    'price' => 12.00,
                    'image' => null,
                    'category_id' => $cocktails->id,
                ],
                [
                    'name' => 'Margarita',
                    'description' => 'Tequila, triple sec, and lime juice.',
                    'price' => 11.50,
                    'image' => null,
                    'category_id' => $cocktails->id,
                ],
            ]);
        }

        // Breakfast Menu Items
        $continentalBreakfast = Category::where('name', 'Continental Breakfast')->first();
        if ($continentalBreakfast) {
            MenuItem::insert([
                [
                    'name' => 'Assorted Pastries',
                    'description' => 'Selection of fresh baked pastries.',
                    'price' => 8.50,
                    'image' => null,
                    'category_id' => $continentalBreakfast->id,
                ],
                [
                    'name' => 'Fresh Fruit Plate',
                    'description' => 'Seasonal fruits with yogurt.',
                    'price' => 9.00,
                    'image' => null,
                    'category_id' => $continentalBreakfast->id,
                ],
            ]);
        }

        $hotBreakfast = Category::where('name', 'Hot Breakfast')->first();
        if ($hotBreakfast) {
            MenuItem::insert([
                [
                    'name' => 'Eggs Benedict',
                    'description' => 'Poached eggs on English muffin with hollandaise.',
                    'price' => 14.50,
                    'image' => null,
                    'category_id' => $hotBreakfast->id,
                ],
                [
                    'name' => 'Belgian Waffles',
                    'description' => 'Fluffy waffles with maple syrup and butter.',
                    'price' => 12.00,
                    'image' => null,
                    'category_id' => $hotBreakfast->id,
                ],
            ]);
        }

        // Maserati Menu Items (Premium)
        $premiumAppetizers = Category::where('name', 'Premium Appetizers')->first();
        if ($premiumAppetizers) {
            MenuItem::insert([
                [
                    'name' => 'Truffle Arancini',
                    'description' => 'Crispy risotto balls with truffle aioli.',
                    'price' => 16.50,
                    'image' => null,
                    'category_id' => $premiumAppetizers->id,
                ],
                [
                    'name' => 'Lobster Bisque',
                    'description' => 'Creamy lobster soup with cognac.',
                    'price' => 18.00,
                    'image' => null,
                    'category_id' => $premiumAppetizers->id,
                ],
            ]);
        }

        $gourmetEntrees = Category::where('name', 'Gourmet Entrees')->first();
        if ($gourmetEntrees) {
            MenuItem::insert([
                [
                    'name' => 'Wagyu Beef Steak',
                    'description' => 'Premium Japanese beef with truffle sauce.',
                    'price' => 45.00,
                    'image' => null,
                    'category_id' => $gourmetEntrees->id,
                ],
                [
                    'name' => 'Lobster Thermidor',
                    'description' => 'Classic French lobster preparation.',
                    'price' => 38.50,
                    'image' => null,
                    'category_id' => $gourmetEntrees->id,
                ],
            ]);
        }

        // Room Service Items
        $classics = Category::where('name', '24/7 Classics')->first();
        if ($classics) {
            MenuItem::insert([
                [
                    'name' => 'Club Sandwich',
                    'description' => 'Triple-decker with turkey, bacon, and vegetables.',
                    'price' => 15.00,
                    'image' => null,
                    'category_id' => $classics->id,
                ],
                [
                    'name' => 'Caesar Salad',
                    'description' => 'Classic Caesar with grilled chicken.',
                    'price' => 13.50,
                    'image' => null,
                    'category_id' => $classics->id,
                ],
            ]);
        }

        $lateNight = Category::where('name', 'Late Night Bites')->first();
        if ($lateNight) {
            MenuItem::insert([
                [
                    'name' => 'Loaded Nachos',
                    'description' => 'Tortilla chips with cheese, jalapeños, and guacamole.',
                    'price' => 12.00,
                    'image' => null,
                    'category_id' => $lateNight->id,
                ],
                [
                    'name' => 'Chicken Wings',
                    'description' => 'Crispy wings with choice of sauce.',
                    'price' => 14.50,
                    'image' => null,
                    'category_id' => $lateNight->id,
                ],
            ]);
        }

        // Snack Menu Items
        $lightBites = Category::where('name', 'Light Bites')->first();
        if ($lightBites) {
            MenuItem::insert([
                [
                    'name' => 'Hummus & Pita',
                    'description' => 'Fresh hummus with warm pita bread.',
                    'price' => 7.50,
                    'image' => null,
                    'category_id' => $lightBites->id,
                ],
                [
                    'name' => 'Caprese Skewers',
                    'description' => 'Mozzarella, tomato, and basil on skewers.',
                    'price' => 8.00,
                    'image' => null,
                    'category_id' => $lightBites->id,
                ],
            ]);
        }

        $sweetTreats = Category::where('name', 'Sweet Treats')->first();
        if ($sweetTreats) {
            MenuItem::insert([
                [
                    'name' => 'Chocolate Chip Cookies',
                    'description' => 'Warm, gooey chocolate chip cookies.',
                    'price' => 4.50,
                    'image' => null,
                    'category_id' => $sweetTreats->id,
                ],
                [
                    'name' => 'Ice Cream Sundae',
                    'description' => 'Vanilla ice cream with hot fudge and nuts.',
                    'price' => 6.00,
                    'image' => null,
                    'category_id' => $sweetTreats->id,
                ],
            ]);
        }

        $this->command->info('Menu items seeded successfully!');
    }
} 