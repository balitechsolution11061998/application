<?php

namespace Database\Seeders;

use App\Models\Bonus;
use App\Models\Expense;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $internalCompanyId = DB::table('companies')->where('code', 'INTERNAL')->value('id');
        
        if (!$internalCompanyId) {
            throw new \Exception("INTERNAL company not found. Please seed companies first.");
        }

        // Define regular products
        $products = [
            [
                'name' => 'Dive Fee', 
                'price' => 20000, 
                'sku' => 'DIVE-FEE',
                'image' => '/img/pos/dive.jpeg'
            ],
            [
                'name' => 'Oper GBB', 
                'price' => 200000, 
                'sku' => 'OPER-GBB'
            ],
            [
                'name' => 'Janggolan Dalam', 
                'price' => 125000, 
                'sku' => 'JANGGOLAN-DALAM',
                'image' => '/img/pos/janggolan-dalam.jpg'
            ],
            [
                'name' => 'Janggolan Dalam Up', 
                'price' => 15000, 
                'sku' => 'JANGGOLAN DALAM UP',
                'image' => '/img/pos/janggolan-dalam.jpg'
            ],
            [
                'name' => 'Janggolan Luar 2x DV', 
                'price' => 200000, 
                'sku' => 'JANGGOLAN LUAR 2x DV',
                'image' => '/img/pos/janggolan-dalam.jpg'
            ],
            [
                'name' => 'Janggolan Luar 3x DV', 
                'price' => 325000, 
                'sku' => 'JANGGOLAN LUAR 3x DV',
                'image' => '/img/pos/janggolan-dalam.jpg'
            ],
            [
                'name' => 'Janggolan Luar Up', 
                'price' => 25000, 
                'sku' => 'JANGGOLAN-LUAR-UP',
                'image' => '/img/pos/janggolan-dalam.jpg'
            ],
            [
                'name' => 'Oper Jet Ski', 
                'price' => 100000, 
                'sku' => 'OPER-JET-SKI',
                'image' => '/img/pos/jetski.jpeg'
            ],
            [
                'name' => 'Oper Jet Ski Lepas Kecil', 
                'price' => 400000, 
                'sku' => 'OPER-JET-SKI-LEPAS-KECIL',
                'image' => '/img/pos/jetski.jpeg'
            ],
            [
                'name' => 'Oper Jet Ski Lepas Besar', 
                'price' => 500000, 
                'sku' => 'OPER-JET-SKI-LEPAS-BESAR',
                'image' => '/img/pos/jetski.jpeg'
            ],
            [
                'name' => 'Oper Par Adv', 
                'price' => 125000, 
                'sku' => 'OPER-PAR-ADV',
                'image' => '/img/pos/adventur.jpeg'
            ],
            [
                'name' => 'Oper Fly Fish', 
                'price' => 100000, 
                'sku' => 'OPER-FLY-FISH',
                'image' => '/img/pos/flyfish.webp'
            ],
            [
                'name' => 'Oper Sea Walker', 
                'price' => 150000, 
                'sku' => 'OPER-SEA-WALKER'
            ],
            [
                'name' => 'Oper Fly Board', 
                'price' => 275000, 
                'sku' => 'OPER-FLY-BOARD'
            ],
            // Add the products that will have bonuses
            [
                'name' => 'Banana Boat Ride', 
                'price' => 175000, 
                'sku' => 'BANANA-BOAT'
            ],
            [
                'name' => 'Tubbing Ride', 
                'price' => 150000, 
                'sku' => 'TUBBING'
            ],
        ];

        // Define expenses
        $expenses = [
            [
                'name' => 'Oper GBB', 
                'amount' => 200000, 
                'code' => 'OPR-GBB',
                'category' => 'operational'
            ],
            [
                'name' => 'Sewa alat Dive', 
                'amount' => 0, 
                'code' => 'EXP-DIVE',
                'category' => 'equipment'
            ],
            [
                'name' => 'ist Tanari', 
                'amount' => 0, 
                'code' => 'EXP-TANARI',
                'category' => 'personnel'
            ],
        ];

        // Seed products first
        $createdProducts = [];
        foreach ($products as $productData) {
            $product = Product::create([
                'company_id' => $internalCompanyId,
                'name' => $productData['name'],
                'price' => $productData['price'],
                'sku' => $productData['sku'],
                'is_active' => true,
                'description' => $productData['name'],
                'image' => isset($productData['image']) ? $productData['image'] : '',
                'upc' => null,
                'options' => null,
            ]);
            $createdProducts[$productData['sku']] = $product;
        }

        // Define bonuses that will link to existing products
        $bonuses = [
            [
                'product_sku' => 'BANANA-BOAT', // This must match an existing product SKU
                'name' => 'Bonus Banana Boat',
                'bonus_type' => 'monthly',
                'amount' => 100000,
            ],
            [
                'product_sku' => 'TUBBING', // This must match an existing product SKU
                'name' => 'Bonus Tubbing',
                'bonus_type' => 'monthly',
                'amount' => 150000,
            ],
            [
                'product_sku' => 'OPER-PAR-ADV', // This must match an existing product SKU
                'name' => 'Bonus Par Adv',
                'bonus_type' => 'monthly',
                'amount' => 125000,
            ],
        ];

        // Seed bonuses linked to products
        foreach ($bonuses as $bonusData) {
            if (isset($createdProducts[$bonusData['product_sku']])) {
                Bonus::create([
                    'product_id' => $createdProducts[$bonusData['product_sku']]->id,
                    'name' => $bonusData['name'],
                    'bonus_type' => $bonusData['bonus_type'],
                    'amount' => $bonusData['amount'],
                    'valid_from' => now(),
                    'valid_to' => now()->addMonth(),
                    'is_active' => true,
                ]);
            } else {
                throw new \Exception("Product with SKU {$bonusData['product_sku']} not found for bonus creation.");
            }
        }

        // Seed expenses
        foreach ($expenses as $expenseData) {
            Expense::create([
                'company_id' => $internalCompanyId,
                'name' => $expenseData['name'],
                'amount' => $expenseData['amount'],
                'code' => $expenseData['code'],
                'description' => $expenseData['name'],
                'category' => $expenseData['category'],
                'is_recurring' => true,
                'recurrence' => 'monthly',
                'is_active' => true,
            ]);
        }
    }
}