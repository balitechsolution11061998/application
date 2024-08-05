<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Department;
use App\Models\Jabatan;
use App\Models\Cabang;
use App\Models\Role;
use App\Models\KonfigurasiJamKerja;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    private function createUsersWithRole(string $roleName, $faker, array $departmentIds, array $jabatans, array $cabang)
    {
        $role = Role::where('name', $roleName)->first();

        if ($role) {
            // Define specific cabang IDs for Badung and Bangli
            $badungCabangIds = [1, 2, 3]; // Example IDs for Badung
            $bangliCabangIds = [4, 5, 6]; // Example IDs for Bangli

            foreach ($departmentIds as $departmentId) {
                foreach ($cabang as $cabangId) {
                    // Check if the cabang ID belongs to Badung or Bangli
                    if (in_array($cabangId, $badungCabangIds)) {
                        $userCount = 10; // Fixed number for Badung
                    } elseif (in_array($cabangId, $bangliCabangIds)) {
                        $userCount = 10; // Fixed number for Bangli
                    } else {
                        $userCount = rand(2, 10); // Random number for other districts
                    }

                    for ($i = 1; $i <= $userCount; $i++) {
                        $username = $faker->unique()->numberBetween(10000000, 99999999);

                        // Set the photo based on the role
                        $photo = '/image/logo1.jpg';
                        if ($roleName === 'guru' || $roleName === 'siswa') {
                            $photo = '/image/logo2.jpg';
                        }

                        $userData = [
                            'username' => $username,
                            'name' => $faker->name,
                            'email' => $faker->unique()->safeEmail,
                            'password_show' => '12345678',
                            'password' => Hash::make('12345678'),
                            'region' => '1',
                            'phone_number' => $faker->phoneNumber,
                            'nik' => $faker->unique()->numberBetween(10000000, 99999999),
                            'join_date' => $faker->date,
                            'status' => 'y',
                            'alamat' => $faker->address,
                            'photo' => $photo, // Assign photo based on role
                            'kode_dept' => $departmentId,
                            'kode_jabatan' => $faker->randomElement($jabatans),
                            'kode_cabang' => $cabangId,
                        ];

                        $user = User::updateOrCreate(
                            ['username' => $userData['username']],
                            $userData
                        );

                        $user->syncRoles([$role->name]);

                        if ($roleName === 'karyawan') {
                            $this->createKonfigurasiJamKerja($user, $faker);
                        }else   if ($roleName === 'siswa') {
                            $this->createSiswaRecord($user, $faker);
                        }
                    }
                }
            }
        } else {
            echo "Role '{$roleName}' not found!\n";
        }
    }

    private function createSiswaRecord(User $user, $faker)
    {
        // Assuming you have a Siswa model and a relationship with Rombel model
        $siswaData = [
            'rombel_id' => \App\Models\Rombel::inRandomOrder()->first()->id, // Assign a random Rombel ID
            'nama' => $user->name, // Use the user's name for the 'nama' field
            'nis' => $user->nik,
            'jenis_kelamin' => $faker->randomElement(['L', 'P']), // Randomly assign gender
        ];

        \App\Models\Siswa::updateOrCreate(
            ['nis' => $siswaData['nis']], // Use 'nis' as the unique identifier
            $siswaData
        );
    }

    private function createKonfigurasiJamKerja(User $user, $faker)
    {
        // Fetch available jam_kerja codes
        $jamKerjaCodes = DB::table('jam_kerja')->pluck('kode_jk')->toArray();

        // Define sample working days
        $workingDays = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        foreach ($workingDays as $day) {
            $kode_jam_kerja = $faker->randomElement($jamKerjaCodes);

            $configData = [
                'kode_jam_kerja' => $kode_jam_kerja,
                'nik' => $user->nik,
                'hari' => $day,
            ];

            KonfigurasiJamKerja::updateOrCreate(
                [
                    'nik' => $user->nik,
                    'hari' => $day,
                ],
                $configData
            );
        }
    }

    public function run()
    {
        $faker = Faker::create('id_ID');

        // Example data for jam_kerja table
        $data = [
            [
                'kode_jk' => 'JK001',
                'nama_jk' => 'Jam Kerja Pagi',
                'awal_jam_masuk' => '08:00:00',
                'jam_masuk' => '08:30:00',
                'akhir_jam_masuk' => '09:00:00',
                'jam_pulang' => '17:00:00',
                'lintas_hari' => false,
            ],
            [
                'kode_jk' => 'JK002',
                'nama_jk' => 'Jam Kerja Siang',
                'awal_jam_masuk' => '12:00:00',
                'jam_masuk' => '12:30:00',
                'akhir_jam_masuk' => '13:00:00',
                'jam_pulang' => '21:00:00',
                'lintas_hari' => false,
            ],
            [
                'kode_jk' => 'JK003',
                'nama_jk' => 'Jam Kerja Malam',
                'awal_jam_masuk' => '22:00:00',
                'jam_masuk' => '22:30:00',
                'akhir_jam_masuk' => '23:00:00',
                'jam_pulang' => '07:00:00',
                'lintas_hari' => true,
            ],
        ];

        // Insert example data into jam_kerja
        DB::table('jam_kerja')->insert($data);

        // Create a single superadministrator
        $this->createSuperadministrator();
        $this->createAdminCbt();
        $this->createAdminEPresensi();
        $this->createGuru();

        // Fetch department, jabatan, and cabang IDs
        $departmentIds = Department::pluck('id')->toArray();
        $jabatans = Jabatan::pluck('id')->toArray();
        $cabang = Cabang::pluck('id')->toArray();

        // Create users with roles
        $this->createUsersWithRole('siswa', $faker, $departmentIds, $jabatans, $cabang);
        $this->createUsersWithRole('karyawan', $faker, $departmentIds, $jabatans, $cabang);
        // Add more roles as needed
    }

    private function createSuperadministrator()
    {
        $role = Role::where('name', 'superadministrator')->first();

        if ($role) {
            $username = 'superadministrator';
            $userData = [
                'username' => $username,
                'name' => 'Super Administrator',
                'email' => 'superadmin@example.com',
                'password_show' => 'Superman2000@',
                'password' => Hash::make('Superman2000@'),
                'region' => '1',
                'phone_number' => '0000000000',
                'nik' => '99999999',
                'join_date' => now(),
                'status' => 'y',
                'alamat' => 'Super Admin Address',
                'photo' => '/image/logo.png',
                'kode_dept' => null,
                'kode_jabatan' => null,
                'kode_cabang' => null,
            ];

            $user = User::updateOrCreate(
                ['username' => $userData['username']],
                $userData
            );

            $user->syncRoles([$role->name]);
        } else {
            echo "Role 'superadministrator' not found!\n";
        }
    }

    private function createAdminCbt()
    {
        $role = Role::where('name', 'admin_cbt')->first();

        if ($role) {
            $username = 'admincbt';
            $userData = [
                'username' => $username,
                'name' => 'Admin CBT',
                'email' => 'admincbt@example.com',
                'password_show' => 'CbtAdmin123!',
                'password' => Hash::make('CbtAdmin123!'),
                'region' => '1',
                'phone_number' => '0000000000',
                'nik' => '88888888',
                'join_date' => now(),
                'status' => 'y',
                'alamat' => 'Admin CBT Address',
                'photo' => '/image/logo2.jpg',
                'kode_dept' => null,
                'kode_jabatan' => null,
                'kode_cabang' => null,
            ];

            $user = User::updateOrCreate(
                ['username' => $userData['username']],
                $userData
            );

            $user->syncRoles([$role->name]);
        } else {
            echo "Role 'admin_cbt' not found!\n";
        }
    }

    private function createGuru()
    {
        $role = Role::where('name', 'guru')->first();

        if ($role) {
            $username = 'guru';
            $userData = [
                'username' => $username,
                'name' => 'Guru ',
                'email' => 'guru@example.com',
                'password_show' => 'Guru123!',
                'password' => Hash::make('Guru123!'),
                'region' => '1',
                'phone_number' => '0000000000',
                'nik' => '88888888',
                'join_date' => now(),
                'status' => 'y',
                'alamat' => 'Guru Address',
                'photo' => '/image/logo2.jpg',
                'kode_dept' => null,
                'kode_jabatan' => null,
                'kode_cabang' => null,
            ];

            $user = User::updateOrCreate(
                ['username' => $userData['username']],
                $userData
            );

            $user->syncRoles([$role->name]);
        } else {
            echo "Role 'admin_cbt' not found!\n";
        }
    }

    private function createAdminEPresensi()
    {
        $role = Role::where('name', 'admin_karyawan')->first();

        if ($role) {
            $username = 'admin_karyawan';
            $userData = [
                'username' => $username,
                'name' => 'Admin E Presensi',
                'email' => 'adminkaryawan@example.com',
                'password_show' => 'EPresensi123!',
                'password' => Hash::make('EPresensi123!'),
                'region' => '1',
                'phone_number' => '0000000000',
                'nik' => '88888888',
                'join_date' => now(),
                'status' => 'y',
                'alamat' => 'Admin Karyawan Address',
                'photo' => '/image/logo1.jpg',
                'kode_dept' => null,
                'kode_jabatan' => null,
                'kode_cabang' => null,
            ];

            $user = User::updateOrCreate(
                ['username' => $userData['username']],
                $userData
            );

            $user->syncRoles([$role->name]);
        } else {
            echo "Role 'admin_cbt' not found!\n";
        }
    }
}
