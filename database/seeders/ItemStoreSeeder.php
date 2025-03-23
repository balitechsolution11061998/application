<?php

namespace Database\Seeders;

use App\Models\ItemStore;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $items = [
            [
                'name' => 'Beef Patty',
                'stock' => 100,
                'unit' => 'pcs',
            ],
            [
                'name' => 'Bread',
                'stock' => 200,
                'unit' => 'pcs',
            ],
            [
                'name' => 'Lettuce',
                'stock' => 50,
                'unit' => 'kg',
            ],
            [
                'name' => 'Tomato',
                'stock' => 30,
                'unit' => 'kg',
            ],
            [
                'name' => 'Cheese',
                'stock' => 80,
                'unit' => 'kg',
            ],
            [
                'name' => 'Potato',
                'stock' => 100,
                'unit' => 'kg',
            ],
            [
                'name' => 'Coca Cola Syrup',
                'stock' => 20,
                'unit' => 'liter',
            ],
            [
                'name' => 'Ice Cream Mix',
                'stock' => 15,
                'unit' => 'kg',
            ],
        ];
    
        foreach ($items as $item) {
            ItemStore::create($item);
        }
    }
}