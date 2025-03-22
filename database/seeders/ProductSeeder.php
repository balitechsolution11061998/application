<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $products = [
            [
                'name' => 'Beef Burger',
                'price' => 45000,
                'image' => 'img/beef-burger.png',
                'options' => null,
            ],
            [
                'name' => 'Sandwich',
                'price' => 32000,
                'image' => 'img/sandwich.png',
                'options' => null,
            ],
            // Tambahkan data lainnya sesuai JSON Anda
        ];
    
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
