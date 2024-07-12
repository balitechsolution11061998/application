<?php

namespace Database\Seeders;

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


        foreach ($data_prov as $provinsi) {
            $provinsi_id = $provinsi['id'];
            $provinsi_name = $provinsi['name'];
            $kode_provinsi = $provinsi['code'];

            // Check if the province is Bali
            if ($provinsi_name == 'Bali') {
                // Get related kabupaten
                $kabupaten_list = array_filter($data_kab, function ($kabupaten) use ($provinsi_id) {
                    return $kabupaten['provinsi_id'] == $provinsi_id;
                });

                foreach ($kabupaten_list as $kabupaten) {
                    $kabupaten_id = $kabupaten['id'];
                    $kabupaten_name = $kabupaten['name'];

                    // Check if the kabupaten is Badung
                    if ($kabupaten_name == 'Badung') {
                        // Get related kecamatan
                        $kecamatan_list = array_filter($data_kec, function ($kecamatan) use ($kabupaten_id) {
                            return $kecamatan['kabupaten_id'] == $kabupaten_id;
                        });

                        foreach ($kecamatan_list as $kecamatan) {
                            $kecamatan_id = $kecamatan['id'];

                            // Get related kelurahan
                            $kelurahan_list = array_filter($data_kel, function ($kelurahan) use ($kecamatan_id) {
                                return $kelurahan['kecamatan_id'] == $kecamatan_id;
                            });

                            foreach ($kelurahan_list as $kelurahan) {
                                $kelurahan_id = $kelurahan['id'];

                                DB::table('cabang')->insert([
                                    'name' => $provinsi_name,
                                    'kode_cabang' => $kode_provinsi,
                                    'provinsi_id' => $provinsi_id,
                                    'kabupaten_id' => $kabupaten_id,
                                    'kecamatan_id' => $kecamatan_id,
                                    'kelurahan_id' => $kelurahan_id,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                            }
                        }
                    }
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

        // Predefined user data
        $dataUser = [
            [
                'username' => '111095',
                'name' => 'I Wayan Bayu Sulaksana',
                'email' => 'notification@supplier.m-mart.co.id',
                'password_show' => 't34m1tmm',
                'password' => bcrypt('t34m1tmm'),
                'region' => '1',
                'phone_number' => '1',
                'nik' => '11223344',
                'join_date' => '2022-12-02',
                'status' => 'y',
                'alamat' => $faker->address,
                'photo' => '/image/logo.png',
            ],
        ];

        // Fetch department IDs
        $departmentIds = Department::pluck('id')->toArray();
        $jabatans = Jabatan::pluck('id')->toArray();
        $cabang = Cabang::pluck('id')->toArray();

        // Add predefined user
        foreach ($dataUser as $data) {
            $data['kode_dept'] = $faker->randomElement($departmentIds); // Assign a random department ID
            $data['kode_jabatan'] = $faker->randomElement($jabatans); // Assign a random department ID
            $data['kode_cabang'] = $faker->randomElement($cabang); // Assign a random department ID

            User::factory()->create($data);

            $user = User::where('email', $data['email'])->first();

            if ($user) {
                $role = Role::whereIn('name', ['superadministrator'])->get()->toArray();
                if ($role) {
                    $user->syncRoles($role);
                } else {
                    echo "Role not found!";
                }
            } else {
                echo "User not found!";
            }
        }

        // Generate fake users
        for ($i = 0; $i < 100; $i++) {
            $fakeUser = [
                'username' => $faker->userName,
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password_show' => 'password', // Placeholder password
                'password' => bcrypt('password'), // Placeholder password
                'region' => $faker->randomDigitNotNull,
                'phone_number' => $faker->phoneNumber,
                'nik' => $faker->randomNumber(8, true),
                'join_date' => $faker->date,
                'alamat'=>$faker->address,
                'status' => $faker->randomElement(['y', 'n']),
                'photo' => $faker->imageUrl(640, 480, 'people'),
                'kode_dept' => $faker->randomElement($departmentIds), // Assign a random department ID
                'kode_jabatan' => $faker->randomElement($jabatans), // Assign a random department ID
                'kode_cabang' => $faker->randomElement($cabang), // Assign a random department ID
            ];

            User::factory()->create($fakeUser);
        }
        //    // // Insert data into suppliers table
        //    $faker = Faker::create('id_ID'); // Set locale to Indonesia

        //    for ($i = 0; $i < 5000; $i++) {
        //         Supplier::create([
        //             'supp_code' => $faker->unique()->numberBetween(1, 5000),
        //             'supp_name' => $faker->company,
        //             'terms' => $faker->numberBetween(1, 60),
        //             'contact_name' => $faker->name,
        //             'contact_phone' => $faker->phoneNumber,
        //             'contact_fax' => $faker->phoneNumber,
        //             'email' => $faker->unique()->safeEmail,
        //             'address_1' => $faker->streetAddress,
        //             'address_2' => $faker->address, // Changed to a general address format
        //             'city' => $faker->city,
        //             'post_code' => $faker->postcode,
        //             'tax_ind' => $faker->randomElement(['Y', 'N']),
        //             'tax_no' => $faker->randomNumber(9, true),
        //             'retur_ind' => $faker->randomElement(['Y', 'N']),
        //             'consig_ind' => $faker->randomElement(['Y', 'N']),
        //             'status' => $faker->randomElement(['A', 'I']),
        //         ]);
        //     }







        // // Set roles


        // $suppliers = [
        //     [
        //         'username' => '900484',
        //         'name' => 'SUKANDA DJAYA, DIAMOND',
        //         'phone_number' => '08991903768',
        //         'email' => 'RPA.Dev@diamond.co.id',
        //     ],
        //     [
        //         'username' => '111095',
        //         'name' => 'SUKANDA DJAYA,PT',
        //         'phone_number' => '08991903768',
        //         'email' => 'dpssmspv@diamond.co.id',
        //     ],
        //     [
        //         'username' => '111077',
        //         'name' => 'PURI PANGAN UTAMA,PT',
        //         'phone_number' => '081999566316',
        //         'email' => 'pangan_utama@yahoo.co.id',
        //     ],
        //     [
        //         'username' => '111254',
        //         'name' => 'BAHTERA WIRANIAGA INTERNUSA PT',
        //         'phone_number' => '081999528836',
        //         'email' => 'finance2bali@pt-bahtera.co.id',
        //     ],
        //     [
        //         'username' => '111188',
        //         'name' => 'SO GOOD FOOD, PT',
        //         'phone_number' => '081239361022',
        //         'email' => 'gita.puspitasari@japfa.com',
        //     ],
        //     [
        //         'username' => '151034',
        //         'name' => 'GAMBINO ARTISAN PRIMA PT. - KO',
        //         'phone_number' => '081310324456',
        //         'email' => 'gambinocoffee@gmail.com',
        //     ],
        //     [
        //         'username' => '112151',
        //         'name' => 'JARI PERKASA PPN',
        //         'phone_number' => '082341205800',
        //         'email' => 'jariperkasa@ymail.com',
        //     ],
        //     [
        //         'username' => '111149',
        //         'name' => 'JARI PERKASA, CV',
        //         'phone_number' => '08990171704',
        //         'email' => 'dirajariperkasa@gmail.com',
        //     ],
        //     [
        //         'username' => '111157',
        //         'name' => 'MASUYA PPN',
        //         'phone_number' => '081337099026',
        //         'email' => 'balirsm@masuya.co.id',
        //     ],
        //     [
        //         'username' => '162082',
        //         'name' => 'PANGAN MITRA BALI, CV',
        //         'phone_number' => '081393650484',
        //         'email' => 'cvpanganmitrabali@gmail.com',
        //     ],
        //     [
        //         'username' => '162077',
        //         'name' => 'CHEESE WORKS BALI, PT',
        //         'phone_number' => '085103012935',
        //         'email' => 'cheeseworksbali@gmail.com',
        //     ],
        //     [
        //         'username' => '111225',
        //         'name' => 'Kaifa Indonesia, PT',
        //         'phone_number' => '62818263202',
        //         'email' => 'yulia@kaifafood.com',
        //     ],
        //     [
        //         'username' => '151089',
        //         'name' => 'Kaifa Indonesia - Dairy',
        //         'phone_number' => '62818263202',
        //         'email' => 'yulia@kaifafood.com',
        //     ],
        // ];

        // foreach ($suppliers as $supplier) {
        //     User::factory()->create([
        //         'username' => $supplier['username'],
        //         'name' => $supplier['name'],
        //         'email' => $supplier['email'], // Parse and extract emails
        //         'phone_number' => $supplier['phone_number'],
        //         'password' => bcrypt('12345678'), // Set default password
        //         'region' => '1', // Assuming default region is '1'
        //     ]);
        //     $user = User::where('email',  $supplier['email'])->first();
        //     if ($user) {
        //         $role = Role::whereIn('name', ['supplier'])->get()->toArray(); // Specify roles in an array
        //         if ($role) {
        //             $user->syncRoles($role);
        //         } else {
        //             // Handle if the role doesn't exist
        //             echo "Role not found!";
        //         }
        //     } else {
        //         // Handle if the user doesn't exist
        //         echo "User not found!";
        //     }
        // }

        // User::factory()->create([
        //     'username' => '1',
        //     'name' => 'Admin MD Region',
        //     'email' => 'test2@gmail.com',
        //     'password' => bcrypt('12345678'),
        //     'region' => '1',
        // ]);
        // // Set roles
        // $user = User::where('email', 'test2@gmail.com')->first();
        // if ($user) {
        //     $role = Role::whereIn('name', ['admin-md-region'])->get()->toArray(); // Specify roles in an array
        //     if ($role) {
        //         $user->syncRoles($role);
        //     } else {
        //         // Handle if the role doesn't exist
        //         echo "Role not found!";
        //     }
        // } else {
        //     // Handle if the user doesn't exist
        //     echo "User not found!";
        // }

        // $dc =
        // [
        //     [
        //         'username' => 'whbali',
        //         'name' => 'WH Bali',
        //         'email' => 'wh1.mm@rcoid.com',
        //         'password' => bcrypt('12345678'),
        //         'region' => '1',
        //         'phone_number' => '08123456789',
        //         'link_sync' => 'https://supplier.m-mart.co.id',
        //     ],
        //     [
        //         'username' => 'whlombok',
        //         'name' => 'WH Lombok',
        //         'email' => 'wh2.mm@rcoid.com',
        //         'password' => bcrypt('12345678'),
        //         'region' => '1',
        //         'phone_number' => '08123456789',
        //         'link_sync' => 'https://supplier.m-mart.co.id',
        //     ],
        //     [
        //         'username' => 'whmakasar',
        //         'name' => 'WH Makasar',
        //         'email' => 'wh3.mm@rcoid.com',
        //         'password' => bcrypt('12345678'),
        //         'region' => '1',
        //         'phone_number' => '08123456789',
        //         'link_sync' => 'https://supplier.m-mart.co.id',
        //     ],
        // ];
        // foreach ($dc as $data) {
        //     User::factory()->create([
        //         'username' => $data['username'],
        //         'name' => $data['name'],
        //         'email' => $data['email'], // Parse and extract emails
        //         'phone_number' => $data['phone_number'],
        //         'password' => $data['password'], // Set default password
        //         'region' => '1', // Assuming default region is '1'
        //     ]);
        //     $user = User::where('email', $data['email'])->first();

        //     if ($user) {
        //         $role = Role::whereIn('name', ['wh'])->get()->toArray(); // Specify roles in an array
        //         if ($role) {
        //             $user->syncRoles($role);
        //         } else {
        //             // Handle if the role doesn't exist
        //             echo "Role not found!";
        //         }
        //     } else {
        //         // Handle if the user doesn't exist
        //         echo "User not found!";
        //     }
        // }

        // $operation =
        // [
        //     [
        //         'username' => 'oprbali',
        //         'name' => 'OPR Bali',
        //         'email' => 'oprbali.mm@rcoid.com',
        //         'password' => bcrypt('12345678'),
        //         'region' => '1',
        //         'phone_number' => '08123456789',
        //         'link_sync' => 'https://supplier.m-mart.co.id',
        //     ],
        //     [
        //         'username' => 'oprlombok',
        //         'name' => 'Operation Lombok',
        //         'email' => 'oprlombok.mm@rcoid.com',
        //         'password' => bcrypt('12345678'),
        //         'region' => '1',
        //         'phone_number' => '08123456789',
        //         'link_sync' => 'https://supplier.m-mart.co.id',
        //     ],
        //     [
        //         'username' => 'oprmakasar',
        //         'name' => 'Operation Makasar',
        //         'email' => 'oprmakasar.mm@rcoid.com',
        //         'password' => bcrypt('12345678'),
        //         'region' => '1',
        //         'phone_number' => '08123456789',
        //         'link_sync' => 'https://supplier.m-mart.co.id',
        //     ],
        // ];
        // foreach ($operation as $data) {
        //     User::factory()->create([
        //         'username' => $data['username'],
        //         'name' => $data['name'],
        //         'email' => $data['email'], // Parse and extract emails
        //         'phone_number' => $data['phone_number'],
        //         'password' => $data['password'], // Set default password
        //         'region' => '1', // Assuming default region is '1'
        //     ]);
        //     $user = User::where('email', $data['email'])->first();

        //     if ($user) {
        //         $role = Role::whereIn('name', ['opr'])->get()->toArray(); // Specify roles in an array
        //         if ($role) {
        //             $user->syncRoles($role);
        //         } else {
        //             // Handle if the role doesn't exist
        //             echo "Role not found!";
        //         }
        //     } else {
        //         // Handle if the user doesn't exist
        //         echo "User not found!";
        //     }
        // }
    }

}
