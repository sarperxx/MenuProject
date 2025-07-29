<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        Menu::insert([
            [
                'name' => 'Akşam Yemeği Menüsü',
                'slug' => 'aksam-yemegi-menusu',
                'start_time' => '19:00',
                'end_time' => '23:00',
                'description' => null,
            ],
            [
                'name' => 'İçecek Menüsü',
                'slug' => 'icecek-menusu',
                'start_time' => '08:00',
                'end_time' => '02:00',
                'description' => null,
            ],
            [
                'name' => 'Maserati Menü',
                'slug' => 'maserati-menusu',
                'start_time' => '17:00',
                'end_time' => '01:00',
                'description' => 'Maserati Lounge ile lüksü hissedin',
            ],
            [
                'name' => 'Oda Kahvaltısı Menüsü',
                'slug' => 'oda-kahvaltisi-menusu',
                'start_time' => '08:00',
                'end_time' => '11:30',
                'description' => null,
            ],
            [
                'name' => 'Oda Servisi Menüsü',
                'slug' => 'oda-servisi-menusu',
                'start_time' => '08:00',
                'end_time' => '02:00',
                'description' => null,
            ],
            [
                'name' => 'Snack Menu',
                'slug' => 'snack-menu',
                'start_time' => '12:00',
                'end_time' => '17:30',
                'description' => null,
            ],
            [
                'name' => 'Suşi Menüsü',
                'slug' => 'susi-menusu',
                'start_time' => '14:00',
                'end_time' => '22:00',
                'description' => null,
            ],
        ]);
}
}