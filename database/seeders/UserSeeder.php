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


    public function run()
    {
        $role = Role::where('name', 'superadministrator')->first();

        if ($role) {
            $username = 'superadministrator';
            $userData = [
                'username' => $username,
                'name' => 'Super Administrator',
                'email' => 'sulaksana60@gmail.com',
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


}
