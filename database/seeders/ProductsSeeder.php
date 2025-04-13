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

        // Define regular products (no bonuses here)
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
        ];

        // Define bonuses (standalone, not connected to products)
        $bonuses = [
            [
                'name' => 'Bonus Banana',
                'amount' => 2000,
                'code' => 'BON-BANANO'
            ],
            [
                'name' => 'Bonus Tubbing',
                'amount' => 3000,
                'code' => 'BON-TUBBING'
            ],
            [
                'name' => 'Bonus par Adv',
                'amount' => 10000,
                'code' => 'BON-Adv'
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

        // Seed regular products
        foreach ($products as $productData) {
            Product::create([
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
        }

        // Seed standalone bonuses
        foreach ($bonuses as $bonusData) {
            Bonus::create([
                'company_id' => $internalCompanyId,
                'name' => $bonusData['name'],
                'amount' => $bonusData['amount'],
                'code' => $bonusData['code'],
                'bonus_type' => 'monthly',
                'valid_from' => now(),
                'valid_to' => now()->addMonth(),
                'is_active' => true,
            ]);
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