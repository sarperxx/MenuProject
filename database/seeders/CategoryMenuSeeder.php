<?php

namespace Database\Seeders;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menu = Menu::where('slug', 'aksam-yemegi-menusu')->first();

        $categories = Category::whereIn('name', [
            'Çorbalar', 'Ana Yemekler', 'Tatlılar'
        ])->pluck('id');

        $menu->categories()->sync($categories);
    }
}
