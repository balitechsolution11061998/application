<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Department;
use App\Models\Jabatan;
use App\Models\Cabang;
use App\Models\Role;
use App\Models\Rombel;
use App\Models\Siswa;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Predefined user data
        $dataUser = [
            [
                'username' => '219811991',
                'name' => 'I Wayan Bayu Sulaksana',
                'email' => 'notification@supplier.m-mart.co.id',
                'password_show' => '12345678',
                'password' => Hash::make('Superman2000@'),
                'region' => '1',
                'phone_number' => '1',
                'nik' => '11223344',
                'join_date' => '2022-12-02',
                'status' => 'y',
                'alamat' => $faker->address,
                'photo' => '/image/logo.png',
            ],
            [
                'username' => 'karyawan1',
                'name' => 'Karyawan 1',
                'email' => 'karyawan1@gmail.com',
                'password_show' => '12345678',
                'password' => Hash::make('12345678'),
                'region' => '1',
                'phone_number' => '089534386678',
                'nik' => '219092349',
                'join_date' => '2022-12-02',
                'status' => 'y',
                'alamat' => 'Sumenep',
                'photo' => '/image/logo.png',
            ],
        ];

        // Fetch department IDs
        $departmentIds = Department::pluck('id')->toArray();
        $jabatans = Jabatan::pluck('id')->toArray();
        $cabang = Cabang::pluck('id')->toArray();

        // Add predefined users
        foreach ($dataUser as $data) {
            $data['kode_dept'] = $faker->randomElement($departmentIds); // Assign a random department ID
            $data['kode_jabatan'] = $faker->randomElement($jabatans); // Assign a random jabatan ID
            $data['kode_cabang'] = $faker->randomElement($cabang); // Assign a random cabang ID

            // Create user
            $user = User::updateOrCreate(
                ['username' => $data['username']],  // Use username to avoid duplicates
                $data
            );

            // Assign roles separately
            if ($user->username === '219811991') {
                $role = Role::where('name', 'superadministrator')->first();
                $user->syncRoles([$role->name]);
            } elseif ($user->username === 'karyawan1') {
                $role = Role::where('name', 'karyawan')->first();
                $user->syncRoles([$role->name]);
            }
        }

        // Generate 600 random users for Siswa
        $roleName = 'siswa';
        $role = Role::where('name', $roleName)->first();

        if ($role) {
            $rombels = Rombel::pluck('id')->toArray();
            for ($i = 1; $i <= 1000; $i++) {
                $userData = [
                    'username' => $faker->unique()->userName,
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'password_show' => '12345678',
                    'password' => Hash::make('12345678'),
                    'region' => $faker->numberBetween(1, 10),
                    'phone_number' => $faker->phoneNumber,
                    'nik' => $faker->unique()->numberBetween(10000000, 99999999),
                    'join_date' => $faker->date,
                    'status' => 'y',
                    'alamat' => $faker->address,
                    'photo' => $faker->imageUrl,
                ];

                $user = User::updateOrCreate(
                    ['username' => $userData['username']],  // Use username to avoid duplicates
                    $userData
                );

                // Assign role to user
                $user->syncRoles([$role->name]);

                // Create corresponding siswa record
                Siswa::create([
                    'rombel_id' => $faker->randomElement($rombels),
                    'nama' => $user->name,
                    'nis' => $faker->unique()->numberBetween(10000000, 99999999),
                    'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                ]);
            }
        } else {
            echo "Role '{$roleName}' not found!";
        }
    }
}
