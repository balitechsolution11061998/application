<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Hapus semua data yang ada di tabel products
        Product::truncate();

        $products = [
            [
                'name' => 'Beef Burger',
                'price' => 45000,
                'image' => '/pos/img/beef-burger.png',
                'sku' => 'SKU12345',
                'upc' => 'UPC123456789',
                'options' => null,
            ],
            [
                'name' => 'Sandwich',
                'price' => 32000,
                'image' => '/pos/img/sandwich.png',
                'sku' => 'SKU67890',
                'upc' => null,
                'options' => null,
            ],
            [
                'name' => 'French Fries',
                'price' => 15000,
                'image' => '/pos/img/french-fries.png',
                'sku' => 'SKU54321',
                'upc' => 'UPC987654321',
                'options' => null,
            ],
            [
                'name' => 'Coca Cola',
                'price' => 10000,
                'image' => '/pos/img/coca-cola.png',
                'sku' => 'SKU11223',
                'upc' => 'UPC112233445',
                'options' => null,
            ],
            [
                'name' => 'Ice Cream',
                'price' => 20000,
                'image' => '/pos/img/ice-cream.png',
                'sku' => 'SKU44556',
                'upc' => 'UPC556677889',
                'options' => null,
            ],
            // Tambahkan produk baru di bawah ini
            [
                'name' => 'Pizza',
                'price' => 75000,
                'image' => '/pos/img/pizza.png',
                'sku' => 'SKU99887',
                'upc' => 'UPC998877665',
                'options' => null,
            ],
            [
                'name' => 'Caesar Salad',
                'price' => 35000,
                'image' => '/pos/img/caesar-salad.png',
                'sku' => 'SKU33445',
                'upc' => 'UPC334455667',
                'options' => null,
            ],
            [
                'name' => 'Fried Chicken',
                'price' => 50000,
                'image' => '/pos/img/fried-chicken.png',
                'sku' => 'SKU55667',
                'upc' => 'UPC556677889',
                'options' => null,
            ],
            [
                'name' => 'Orange Juice',
                'price' => 15000,
                'image' => '/pos/img/orange-juice.png',
                'sku' => 'SKU77889',
                'upc' => 'UPC778899001',
                'options' => null,
            ],
            [
                'name' => 'Cheesecake',
                'price' => 25000,
                'image' => '/pos/img/cheesecake.png',
                'sku' => 'SKU88991',
                'upc' => 'UPC889911223',
                'options' => null,
            ],
        ];
    
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}