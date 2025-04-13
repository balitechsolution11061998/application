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
        
        // Create products first
        $products = [
            // Bonus Products
            ['name' => 'Bonus Banano', 'price' => 2000, 'sku' => 'BON-BANANO'],
            ['name' => 'Bonus Tubbing', 'price' => 3000, 'sku' => 'BON-TUBBING'],
            
            // Expense Products
            ['name' => 'Sewa alat Dive', 'price' => 0, 'sku' => 'EXP-DIVE'],
            ['name' => 'ist Tanari', 'price' => 0, 'sku' => 'EXP-TANARI'],
            
            // Regular Products
            ['name' => 'Diver Art', 'price' => 20000, 'sku' => 'DIV-ART'],
        ];

        foreach ($products as $productData) {
            $product = Product::create(array_merge($productData, [
                'company_id' => $internalCompanyId,
                'is_active' => true,
                'description' => $productData['name'],
                'image' => '',
                'upc' => null,
                'options' => null,
            ]));

            // Create bonus records for bonus items
            if (str_starts_with($productData['sku'], 'BON-')) {
                Bonus::create([
                    'product_id' => $product->id,
                    'bonus_type' => 'monthly',
                    'valid_from' => now(),
                    'valid_to' => now()->addMonth(),
                    'is_active' => true,
                ]);
            }

            // Create expense records for expense items
            if (str_starts_with($productData['sku'], 'EXP-')) {
                Expense::create([
                    'product_id' => $product->id,
                    'expense_category' => 'operational',
                    'is_recurring' => true,
                    'recurrence' => 'monthly',
                    'is_active' => true,
                ]);
            }
        }
    }
}