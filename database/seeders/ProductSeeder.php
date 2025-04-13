<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to avoid issues during truncate
        Schema::disableForeignKeyConstraints();
        
        // Truncate the table first
        DB::table('products')->truncate();
        
        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        $products = [
            // Bonus items
            ['name' => 'Bonus Banano', 'price' => 2000, 'image' => '', 'sku' => 'BON-BANANO', 'description' => 'Banano bonus'],
            ['name' => 'Bonus Tubbing', 'price' => 3000, 'image' => '', 'sku' => 'BON-TUBBING', 'description' => 'Tubbing bonus'],
            ['name' => 'Bonus par Adv', 'price' => 10000, 'image' => '', 'sku' => 'BON-ADV', 'description' => 'Advertisement bonus'],
            
            // Diver and operations
            ['name' => 'Diver Art', 'price' => 20000, 'image' => '', 'sku' => 'DIV-ART', 'description' => 'Diver art service'],
            ['name' => 'Oper CBS', 'price' => 240000, 'image' => '', 'sku' => 'OP-CBS', 'description' => 'CBS operation'],
            ['name' => 'Janggolan Datami', 'price' => 185000, 'image' => '', 'sku' => 'JAN-DATAMI', 'description' => 'Janggolan Datami service'],
            ['name' => 'Janggolan Datami up', 'price' => 15000, 'image' => '', 'sku' => 'JAN-DATAMI-UP', 'description' => 'Janggolan Datami upgrade'],
            ['name' => 'Janggolan luar Maxpv', 'price' => 200000, 'image' => '', 'sku' => 'JAN-MAXPV', 'description' => 'Janggolan luar Maxpv'],
            ['name' => 'Janggolan luar 3x0v', 'price' => 285000, 'image' => '', 'sku' => 'JAN-3X0V', 'description' => 'Janggolan luar 3x0v'],
            ['name' => 'Janggolan luar up', 'price' => 25000, 'image' => '', 'sku' => 'JAN-LUAR-UP', 'description' => 'Janggolan luar upgrade'],
            ['name' => 'Oper Jet Ski', 'price' => 100000, 'image' => '', 'sku' => 'OP-JETSKI', 'description' => 'Jet Ski operation'],
            ['name' => 'Oper Jet Ski lepar Real', 'price' => 40000, 'image' => '', 'sku' => 'OP-JETSKI-REAL', 'description' => 'Jet Ski lepar Real operation'],
            ['name' => 'Oper Jet Ski lepar Beyar', 'price' => 50000, 'image' => '', 'sku' => 'OP-JETSKI-BEYAR', 'description' => 'Jet Ski lepar Beyar operation'],
            ['name' => 'Oper por Adv', 'price' => 125000, 'image' => '', 'sku' => 'OP-ADV', 'description' => 'Advertisement operation'],
            ['name' => 'Oper Fly Fish', 'price' => 120000, 'image' => '', 'sku' => 'OP-FLYFISH', 'description' => 'Fly Fish operation'],
            ['name' => 'Oper Sea wicker', 'price' => 110000, 'image' => '', 'sku' => 'OP-SEAWICKER', 'description' => 'Sea wicker operation'],
            ['name' => 'Oper Hy Board', 'price' => 375000, 'image' => '', 'sku' => 'OP-HYBOARD', 'description' => 'Hy Board operation'],
            
            // Pembagian
            ['name' => 'Pembagian Kangwuan 80%', 'price' => 0, 'image' => '', 'sku' => 'DIST-KANGWUAN', 'description' => 'Kangwuan 80% distribution'],
            ['name' => 'Pembagian CBS 5%', 'price' => 0, 'image' => '', 'sku' => 'DIST-CBS', 'description' => 'CBS 5% distribution'],
            ['name' => 'Briaya Marketing 5%', 'price' => 0, 'image' => '', 'sku' => 'FEE-MARKETING', 'description' => 'Marketing 5% fee'],
            
            // Service items
            ['name' => 'Sewa alat Dive', 'price' => 0, 'image' => '', 'sku' => 'SRV-DIVE', 'description' => 'Dive equipment rental'],
            ['name' => 'ist Tanari', 'price' => 0, 'image' => '', 'sku' => 'SRV-TANARI', 'description' => 'Tanari service'],
            ['name' => 'Post', 'price' => 0, 'image' => '', 'sku' => 'SRV-POST', 'description' => 'Post service'],
            ['name' => 'Plastik Port', 'price' => 0, 'image' => '', 'sku' => 'SRV-PLASTIK', 'description' => 'Plastic port service'],
            ['name' => 'Kresek', 'price' => 0, 'image' => '', 'sku' => 'SRV-KRESEK', 'description' => 'Kresek service'],
            ['name' => 'Sunlight', 'price' => 0, 'image' => '', 'sku' => 'SRV-SUNLIGHT', 'description' => 'Sunlight service'],
            ['name' => 'Shampo', 'price' => 0, 'image' => '', 'sku' => 'SRV-SHAMPO', 'description' => 'Shampoo service'],
            ['name' => 'Portsek', 'price' => 0, 'image' => '', 'sku' => 'SRV-PORTSEK', 'description' => 'Portsek service'],
            ['name' => 'Motto', 'price' => 0, 'image' => '', 'sku' => 'SRV-MOTTO', 'description' => 'Motto service'],
            ['name' => 'Karet', 'price' => 0, 'image' => '', 'sku' => 'SRV-KARET', 'description' => 'Karet service'],
            ['name' => 'Nota', 'price' => 0, 'image' => '', 'sku' => 'SRV-NOTA', 'description' => 'Nota service'],
            ['name' => 'Nota Tanda Tetima', 'price' => 0, 'image' => '', 'sku' => 'SRV-NOTA-TETIMA', 'description' => 'Nota tanda tetima service'],
            ['name' => 'Pogak air', 'price' => 0, 'image' => '', 'sku' => 'SRV-POGAK-AIR', 'description' => 'Pogak air service'],
            ['name' => 'Pogak Hibitou', 'price' => 0, 'image' => '', 'sku' => 'SRV-POGAK-HIBITOU', 'description' => 'Pogak Hibitou service'],
            ['name' => 'Sampan', 'price' => 0, 'image' => '', 'sku' => 'SRV-SAMPAN', 'description' => 'Sampan service'],
            ['name' => 'Cagi Pupdo', 'price' => 0, 'image' => '', 'sku' => 'SRV-CAGI-PUPDO', 'description' => 'Cagi Pupdo service'],
            ['name' => 'Listrik', 'price' => 0, 'image' => '', 'sku' => 'SRV-LISTRIK', 'description' => 'Electricity service'],
            ['name' => 'Wifi', 'price' => 0, 'image' => '', 'sku' => 'SRV-WIFI', 'description' => 'WiFi service'],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'sku' => $product['sku'],
                'upc' => null,
                'description' => $product['description'],
                'options' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}