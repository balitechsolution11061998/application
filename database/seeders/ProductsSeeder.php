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

        // Define products with their types
        $products = [
            // Bonus Products
            [
                'name' => 'Bonus Banana', 
                'price' => 2000, 
                'sku' => 'BON-BANANO',
                'type' => 'bonus'
            ],
            [
                'name' => 'Bonus Tubbing', 
                'price' => 3000, 
                'sku' => 'BON-TUBBING',
                'type' => 'bonus'
            ],
            [
                'name' => 'Bonus par Adv', 
                'price' => 10000, 
                'sku' => 'BON-Adv',
                'type' => 'bonus'
            ],
            [
                'name' => 'Dive Fee', 
                'price' => 10000, 
                'sku' => 'DIVE-FEE',
                'type' => 'regular'
            ],
            
            // Expense Products
            [
                'name' => 'Oper GBB', 
                'price' => 200000, 
                'sku' => 'OPR-GBB',
                'type' => 'expense'
            ],
            [
                'name' => 'Sewa alat Dive', 
                'price' => 0, 
                'sku' => 'EXP-DIVE',
                'type' => 'expense'
            ],
            [
                'name' => 'ist Tanari', 
                'price' => 0, 
                'sku' => 'EXP-TANARI',
                'type' => 'expense'
            ],
            
            // Regular Products
            [
                'name' => 'Diver Art', 
                'price' => 20000, 
                'sku' => 'DIV-ART',
                'type' => 'regular'
            ],
        ];

        foreach ($products as $productData) {
            // Create the base product
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

            // Create associated records based on type
            switch ($productData['type']) {
                case 'bonus':
                    Bonus::create([
                        'product_id' => $product->id,
                        'bonus_type' => 'monthly',
                        'valid_from' => now(),
                        'valid_to' => now()->addMonth(),
                        'is_active' => true,
                    ]);
                    break;
                
                case 'expense':
                    Expense::create([
                        'product_id' => $product->id,
                        'expense_category' => 'operational',
                        'is_recurring' => true,
                        'recurrence' => 'monthly',
                        'is_active' => true,
                    ]);
                    break;
                
                // No additional action needed for regular products
            }
        }
    }
}