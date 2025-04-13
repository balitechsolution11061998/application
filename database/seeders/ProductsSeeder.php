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

        // Define products (regular products and products that will have bonuses)
        $products = [
            // Products that will have bonuses
            [
                'name' => 'Bonus Banana', 
                'price' => 2000, 
                'sku' => 'BON-BANANO',
                'is_bonus' => true
            ],
            [
                'name' => 'Bonus Tubbing', 
                'price' => 3000, 
                'sku' => 'BON-TUBBING',
                'is_bonus' => true
            ],
            [
                'name' => 'Bonus par Adv', 
                'price' => 10000, 
                'sku' => 'BON-Adv',
                'is_bonus' => true
            ],
            // Regular products
            [
                'name' => 'Dive Fee', 
                'price' => 10000, 
                'sku' => 'DIVE-FEE',
                'is_bonus' => false
            ],
            [
                'name' => 'Diver Art', 
                'price' => 20000, 
                'sku' => 'DIV-ART',
                'is_bonus' => false
            ],
        ];

        // Define expenses (separate from products)
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

        // Seed products and bonuses
        foreach ($products as $productData) {
            $product = Product::create([
                'company_id' => $internalCompanyId,
                'name' => $productData['name'],
                'price' => $productData['price'],
                'sku' => $productData['sku'],
                'is_active' => true,
                'description' => $productData['name'],
                'image' => '',
                'upc' => null,
                'options' => null,
            ]);

            // Create bonus record if product is marked as bonus
            if ($productData['is_bonus']) {
                Bonus::create([
                    'product_id' => $product->id,
                    'name' => $productData['name'],
                    'bonus_type' => 'monthly',
                    'valid_from' => now(),
                    'valid_to' => now()->addMonth(),
                    'is_active' => true,
                ]);
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