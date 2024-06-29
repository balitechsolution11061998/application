<?php

namespace Database\Seeders;

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
        // Seed users
        $dataUser =
        [
            [
                'username' => 'sulaksana60',
                'name' => 'I Wayan Bayu Sulaksana',
                'email' => 'notification@supplier.m-mart.co.id',
                'password' => bcrypt('t34m1tmm'),
                'region' => '1',
                'phone_number' => '1',
                'nik' => '11223344',
                'join_date' => '2022-12-02',
                'status' => 'y',
            ],
            [
                'username' => '219811991',
                'name' => 'I Wayan Bayu Sulaksana',
                'email' => 'sulaksana60@gmail.com',
                'password' => bcrypt('Superman2000@'),
                'region' => '1',
                'phone_number' => '62895343866012',
                'status' => 'y',
            ]

        ];
        foreach ($dataUser as $data) {
            User::factory()->create([
                'username' => $data['username'],
                'name' => $data['name'],
                'email' => $data['email'], // Parse and extract emails
                'phone_number' => $data['phone_number'],
                'password' => $data['password'], // Set default password
                'status' => $data['status'],
                'region' => '1', // Assuming default region is '1'
            ]);
            $user = User::where('email', $data['email'])->first();

            if ($user) {
                $role = Role::whereIn('name', ['superadministrator'])->get()->toArray(); // Specify roles in an array
                if ($role) {
                    $user->syncRoles($role);
                } else {
                    // Handle if the role doesn't exist
                    echo "Role not found!";
                }
            } else {
                // Handle if the user doesn't exist
                echo "User not found!";
            }
        }

           // // Insert data into suppliers table
           $faker = Faker::create('id_ID'); // Set locale to Indonesia

           for ($i = 0; $i < 5000; $i++) {
                Supplier::create([
                    'supp_code' => $faker->unique()->numberBetween(1, 5000),
                    'supp_name' => $faker->company,
                    'terms' => $faker->numberBetween(1, 60),
                    'contact_name' => $faker->name,
                    'contact_phone' => $faker->phoneNumber,
                    'contact_fax' => $faker->phoneNumber,
                    'email' => $faker->unique()->safeEmail,
                    'address_1' => $faker->streetAddress,
                    'address_2' => $faker->address, // Changed to a general address format
                    'city' => $faker->city,
                    'post_code' => $faker->postcode,
                    'tax_ind' => $faker->randomElement(['Y', 'N']),
                    'tax_no' => $faker->randomNumber(9, true),
                    'retur_ind' => $faker->randomElement(['Y', 'N']),
                    'consig_ind' => $faker->randomElement(['Y', 'N']),
                    'status' => $faker->randomElement(['A', 'I']),
                ]);
            }







        // Set roles


        $suppliers = [
            [
                'username' => '900484',
                'name' => 'SUKANDA DJAYA, DIAMOND',
                'phone_number' => '08991903768',
                'email' => 'RPA.Dev@diamond.co.id',
            ],
            [
                'username' => '111095',
                'name' => 'SUKANDA DJAYA,PT',
                'phone_number' => '08991903768',
                'email' => 'dpssmspv@diamond.co.id',
            ],
            [
                'username' => '111077',
                'name' => 'PURI PANGAN UTAMA,PT',
                'phone_number' => '081999566316',
                'email' => 'pangan_utama@yahoo.co.id',
            ],
            [
                'username' => '111254',
                'name' => 'BAHTERA WIRANIAGA INTERNUSA PT',
                'phone_number' => '081999528836',
                'email' => 'finance2bali@pt-bahtera.co.id',
            ],
            [
                'username' => '111188',
                'name' => 'SO GOOD FOOD, PT',
                'phone_number' => '081239361022',
                'email' => 'gita.puspitasari@japfa.com',
            ],
            [
                'username' => '151034',
                'name' => 'GAMBINO ARTISAN PRIMA PT. - KO',
                'phone_number' => '081310324456',
                'email' => 'gambinocoffee@gmail.com',
            ],
            [
                'username' => '112151',
                'name' => 'JARI PERKASA PPN',
                'phone_number' => '082341205800',
                'email' => 'jariperkasa@ymail.com',
            ],
            [
                'username' => '111149',
                'name' => 'JARI PERKASA, CV',
                'phone_number' => '08990171704',
                'email' => 'dirajariperkasa@gmail.com',
            ],
            [
                'username' => '111157',
                'name' => 'MASUYA PPN',
                'phone_number' => '081337099026',
                'email' => 'balirsm@masuya.co.id',
            ],
            [
                'username' => '162082',
                'name' => 'PANGAN MITRA BALI, CV',
                'phone_number' => '081393650484',
                'email' => 'cvpanganmitrabali@gmail.com',
            ],
            [
                'username' => '162077',
                'name' => 'CHEESE WORKS BALI, PT',
                'phone_number' => '085103012935',
                'email' => 'cheeseworksbali@gmail.com',
            ],
            [
                'username' => '111225',
                'name' => 'Kaifa Indonesia, PT',
                'phone_number' => '62818263202',
                'email' => 'yulia@kaifafood.com',
            ],
            [
                'username' => '151089',
                'name' => 'Kaifa Indonesia - Dairy',
                'phone_number' => '62818263202',
                'email' => 'yulia@kaifafood.com',
            ],
        ];

        foreach ($suppliers as $supplier) {
            User::factory()->create([
                'username' => $supplier['username'],
                'name' => $supplier['name'],
                'email' => $supplier['email'], // Parse and extract emails
                'phone_number' => $supplier['phone_number'],
                'password' => bcrypt('12345678'), // Set default password
                'region' => '1', // Assuming default region is '1'
            ]);
            $user = User::where('email',  $supplier['email'])->first();
            if ($user) {
                $role = Role::whereIn('name', ['supplier'])->get()->toArray(); // Specify roles in an array
                if ($role) {
                    $user->syncRoles($role);
                } else {
                    // Handle if the role doesn't exist
                    echo "Role not found!";
                }
            } else {
                // Handle if the user doesn't exist
                echo "User not found!";
            }
        }

        User::factory()->create([
            'username' => '1',
            'name' => 'Admin MD Region',
            'email' => 'test2@gmail.com',
            'password' => bcrypt('12345678'),
            'region' => '1',
        ]);
        // Set roles
        $user = User::where('email', 'test2@gmail.com')->first();
        if ($user) {
            $role = Role::whereIn('name', ['admin-md-region'])->get()->toArray(); // Specify roles in an array
            if ($role) {
                $user->syncRoles($role);
            } else {
                // Handle if the role doesn't exist
                echo "Role not found!";
            }
        } else {
            // Handle if the user doesn't exist
            echo "User not found!";
        }

        $dc =
        [
            [
                'username' => 'whbali',
                'name' => 'WH Bali',
                'email' => 'wh1.mm@rcoid.com',
                'password' => bcrypt('12345678'),
                'region' => '1',
                'phone_number' => '08123456789',
                'link_sync' => 'https://supplier.m-mart.co.id',
            ],
            [
                'username' => 'whlombok',
                'name' => 'WH Lombok',
                'email' => 'wh2.mm@rcoid.com',
                'password' => bcrypt('12345678'),
                'region' => '1',
                'phone_number' => '08123456789',
                'link_sync' => 'https://supplier.m-mart.co.id',
            ],
            [
                'username' => 'whmakasar',
                'name' => 'WH Makasar',
                'email' => 'wh3.mm@rcoid.com',
                'password' => bcrypt('12345678'),
                'region' => '1',
                'phone_number' => '08123456789',
                'link_sync' => 'https://supplier.m-mart.co.id',
            ],
        ];
        foreach ($dc as $data) {
            User::factory()->create([
                'username' => $data['username'],
                'name' => $data['name'],
                'email' => $data['email'], // Parse and extract emails
                'phone_number' => $data['phone_number'],
                'password' => $data['password'], // Set default password
                'region' => '1', // Assuming default region is '1'
            ]);
            $user = User::where('email', $data['email'])->first();

            if ($user) {
                $role = Role::whereIn('name', ['wh'])->get()->toArray(); // Specify roles in an array
                if ($role) {
                    $user->syncRoles($role);
                } else {
                    // Handle if the role doesn't exist
                    echo "Role not found!";
                }
            } else {
                // Handle if the user doesn't exist
                echo "User not found!";
            }
        }

        $operation =
        [
            [
                'username' => 'oprbali',
                'name' => 'OPR Bali',
                'email' => 'oprbali.mm@rcoid.com',
                'password' => bcrypt('12345678'),
                'region' => '1',
                'phone_number' => '08123456789',
                'link_sync' => 'https://supplier.m-mart.co.id',
            ],
            [
                'username' => 'oprlombok',
                'name' => 'Operation Lombok',
                'email' => 'oprlombok.mm@rcoid.com',
                'password' => bcrypt('12345678'),
                'region' => '1',
                'phone_number' => '08123456789',
                'link_sync' => 'https://supplier.m-mart.co.id',
            ],
            [
                'username' => 'oprmakasar',
                'name' => 'Operation Makasar',
                'email' => 'oprmakasar.mm@rcoid.com',
                'password' => bcrypt('12345678'),
                'region' => '1',
                'phone_number' => '08123456789',
                'link_sync' => 'https://supplier.m-mart.co.id',
            ],
        ];
        foreach ($operation as $data) {
            User::factory()->create([
                'username' => $data['username'],
                'name' => $data['name'],
                'email' => $data['email'], // Parse and extract emails
                'phone_number' => $data['phone_number'],
                'password' => $data['password'], // Set default password
                'region' => '1', // Assuming default region is '1'
            ]);
            $user = User::where('email', $data['email'])->first();

            if ($user) {
                $role = Role::whereIn('name', ['opr'])->get()->toArray(); // Specify roles in an array
                if ($role) {
                    $user->syncRoles($role);
                } else {
                    // Handle if the role doesn't exist
                    echo "Role not found!";
                }
            } else {
                // Handle if the user doesn't exist
                echo "User not found!";
            }
        }
    }

}
