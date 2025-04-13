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
                'price' => 10000, 
                'sku' => 'DIVE-FEE'
            ],
            [
                'name' => 'Diver Art', 
                'price' => 20000, 
                'sku' => 'DIV-ART'
            ],
            // These will be products that have associated bonuses
            [
                'name' => 'Bonus Banana Product',
                'price' => 2000,
                'sku' => 'PROD-BANANO'
            ],
            [
                'name' => 'Bonus Tubbing Product',
                'price' => 3000,
                'sku' => 'PROD-TUBBING'
            ],
            [
                'name' => 'Bonus par Adv Product',
                'price' => 10000,
                'sku' => 'PROD-ADV'
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
                'image' => '',
                'upc' => null,
                'options' => null,
            ]);
            $createdProducts[$productData['sku']] = $product;
        }

        // Define bonuses that will link to products
        $bonuses = [
            [
                'product_sku' => 'PROD-BANANO',
                'name' => 'Bonus Banana',
                'bonus_type' => 'monthly'
            ],
            [
                'product_sku' => 'PROD-TUBBING',
                'name' => 'Bonus Tubbing',
                'bonus_type' => 'monthly'
            ],
            [
                'product_sku' => 'PROD-ADV',
                'name' => 'Bonus par Adv',
                'bonus_type' => 'monthly'
            ],
        ];

        // Seed bonuses linked to products
        foreach ($bonuses as $bonusData) {
            if (isset($createdProducts[$bonusData['product_sku']])) {
                Bonus::create([
                    'product_id' => $createdProducts[$bonusData['product_sku']]->id,
                    'name' => $bonusData['name'],
                    'bonus_type' => $bonusData['bonus_type'],
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