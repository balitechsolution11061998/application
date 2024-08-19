<?php

namespace Database\Seeders;

use App\Jobs\AddUsersJob;
use App\Jobs\SeedSoalJob;
use App\Models\Cabang;
use App\Models\Department;
use App\Models\Jabatan;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Supplier;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $file_prov = public_path('json/provinsi.json');
        $file_kab = public_path('json/kabupaten.json');
        $file_kec = public_path('json/kecamatan.json');
        $file_kel = public_path('json/kelurahan.json');

        $json_prov = file_get_contents($file_prov);
        $json_kab = file_get_contents($file_kab);
        $json_kec = file_get_contents($file_kec);
        $json_kel = file_get_contents($file_kel);

        $data_prov = json_decode($json_prov, true);
        $data_kab = json_decode($json_kab, true);
        $data_kec = json_decode($json_kec, true);
        $data_kel = json_decode($json_kel, true);

        // Coordinates for your laptop or another specific location
        $laptopLatitude = '-8.459658';  // Example latitude
        $laptopLongitude = '115.355545'; // Example longitude

        $sumenepLatitude = '-7.033425';  // Example latitude for Sumenep
        $sumenepLongitude = '113.657203'; // Example longitude for Sumenep

        // Define the specific kabupaten to insert
        $specificKabupaten = ['bangli', 'badung', 'denpasar','sumenep'];

        foreach ($data_prov as $provinsi) {
            $provinsi_id = $provinsi['id'];

            // Get related kabupaten for the current provinsi
            $kabupaten_list = array_filter($data_kab, function ($kabupaten) use ($provinsi_id) {
                return $kabupaten['provinsi_id'] == $provinsi_id;
            });

            foreach ($kabupaten_list as $kabupaten) {
                $kabupaten_name_lower = strtolower($kabupaten['name']);

                // Only proceed if the kabupaten is one of the specified ones
                if (in_array($kabupaten_name_lower, $specificKabupaten)) {
                    $kabupaten_id = $kabupaten['id'];
                    $kode_kabupaten = $kabupaten['code']; // Assuming `code` is the desired `kode_kabupaten`

                    // Set coordinates for 'Bangli' and null for others
                    if ($kabupaten_name_lower === 'bangli') {
                        $latitude = $laptopLatitude;  // Set latitude for Bangli
                        $longitude = $laptopLongitude; // Set longitude for Bangli
                    } else if ($kabupaten_name_lower === 'sumenep') {
                        $latitude = $sumenepLatitude;  // Set latitude for Bangli
                        $longitude = $sumenepLongitude; // Set longitude for Bangli
                    }
                    else {
                        $latitude = null;  // Default or null for others
                        $longitude = null; // Default or null for others
                    }

                    // Insert cabang record for the specified kabupaten
                    DB::table('cabang')->insert([
                        'name' => $kabupaten['name'],  // Set the name as the kabupaten name
                        'kode_cabang' => $kode_kabupaten,  // Use the kabupaten code as the cabang code
                        'provinsi_id' => $provinsi_id,
                        'kabupaten_id' => $kabupaten_id,
                        'kecamatan_id' => null,  // Set kecamatan_id to null since it's per kabupaten
                        'kelurahan_id' => null,  // Set kelurahan_id to null since it's per kabupaten
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }





        echo "Memulai proses seeder data Provinsi...\n";
        DB::table('provinsi')->insert($data_prov);
        echo "Done seeder data Provinsi...\n";

        echo "Memulai proses seeder data Kabupaten...\n";
        DB::table('kabupaten')->insert($data_kab);
        echo "Done seeder data Kabupaten...\n";

        $chunk_kec = array_chunk($data_kec, 1000);
        foreach ($chunk_kec as $key => $chunk) {
            echo "Memulai proses seeder data Kecamatan... ke " . $key + 1 . "000\n";
            DB::table('kecamatan')->insert($chunk);
            echo "Done seeder data Kecamatan... ke " . $key + 1 . "000\n";
        }

        $chunk_kel = array_chunk($data_kel, 1000);
        foreach ($chunk_kel as $key => $chunk) {
            echo "Memulai proses seeder data Kelurahan... ke " . $key + 1 . "000\n";
            DB::table('kelurahan')->insert($chunk);
            echo "Done seeder data Kelurahan... ke " . $key + 1 . "000\n";
        }

        $jabatans = [
            ['name' => 'President', 'kode_jabatan' => 'PRES'],
            ['name' => 'Vice President', 'kode_jabatan' => 'VPRES'],
            ['name' => 'Governor', 'kode_jabatan' => 'GOV'],
            ['name' => 'Deputy Governor', 'kode_jabatan' => 'DGOV'],
            ['name' => 'Mayor', 'kode_jabatan' => 'MAYOR'],
            ['name' => 'Deputy Mayor', 'kode_jabatan' => 'DMAYOR'],
            ['name' => 'District Head', 'kode_jabatan' => 'DHEAD'],
            ['name' => 'Sub-district Head', 'kode_jabatan' => 'SDHEAD'],
            ['name' => 'Department Head', 'kode_jabatan' => 'DEPTHEAD'],
            ['name' => 'Manager', 'kode_jabatan' => 'MGR'],
            ['name' => 'Chief', 'kode_jabatan' => 'CHIEF'],
            ['name' => 'Supervisor', 'kode_jabatan' => 'SUP'],
            ['name' => 'Team Leader', 'kode_jabatan' => 'TLDR'],
            ['name' => 'Staff', 'kode_jabatan' => 'STF'],
            ['name' => 'Assistant', 'kode_jabatan' => 'AST'],
            // Add more positions as needed
        ];

        // Chunking the data and inserting in batches
        $chunkSize = 1000; // Adjust chunk size as needed
        foreach (array_chunk($jabatans, $chunkSize) as $key => $chunk) {
            echo "Starting seeder data Jabatan... batch " . ($key + 1) . "\n";
            DB::table('jabatan')->insert($chunk);
            echo "Done seeder data Jabatan... batch " . ($key + 1) . "\n";
        }

        $faker = Faker::create('id_ID');
        // Daftar nama departemen dalam bahasa Indonesia
        $departments = [
            'Keuangan',
            'Sumber Daya Manusia',
            'Pemasaran',
            'Penjualan',
            'Teknologi Informasi',
            'Operasional',
            'Produksi',
            'Riset dan Pengembangan',
            'Logistik',
            'Layanan Pelanggan'
        ];

        foreach ($departments as $department) {
            DB::table('departments')->insert([
                'kode_department' => Str::random(10),
                'name' => $department,
                'descriptions' => Str::random(20),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->call(LaratrustSeeder::class);
        $this->call(KelasSeeder::class);
        $this->call(RombelSeeder::class);
        $this->call(MataPelajaranSeeder::class);
        $this->call(CutiSeeder::class);

        // $this->call(UserSeeder::class);
        AddUsersJob::dispatch();
        $this->call(PaketSoalSeeder::class);
        // $this->call(SoalSeeder::class);
        SeedSoalJob::dispatch();

        $this->call(UjianSeeder::class);
        $this->call(OrdheadAndOrdskuSeeder::class);


    }
}
