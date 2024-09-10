<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class LaratrustSeeder extends Seeder
{
  /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = config('laratrust_seeder.roles_structure');
        $permissionsMap = config('laratrust_seeder.permissions_map');

        foreach ($roles as $roleName => $modules) {
            // Create or get the role
            $role = Role::firstOrCreate(['name' => $roleName]);

            // Array to hold the permissions for this role
            $allPermissions = [];

            foreach ($modules as $module => $permissions) {
                $permissionsArray = explode(',', $permissions);

                foreach ($permissionsArray as $permission) {
                    // Construct permission name based on the map and module
                    $permissionName = "{$permissionsMap[$permission]}-{$module}";

                    // Create or find the permission in the database
                    $permission = Permission::firstOrCreate(['name' => $permissionName]);

                    // Add the permission to the array
                    $allPermissions[] = $permission->id;
                }
            }

            // Sync all permissions for the role at once
            $role->permissions()->sync($allPermissions);
        }
    }
}
