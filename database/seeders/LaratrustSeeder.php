<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

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
            // Create or get the role with name and description
            $role = Role::firstOrCreate(
                ['name' => $roleName],
                ['description' => "This is the role for {$roleName}"] // Assuming you want a generic description
            );

            // Display the role name and description
            $this->command->info("Role: {$role->name}, Description: {$role->description}");

            // Array to hold the permissions for this role
            $allPermissions = [];

            foreach ($modules as $module => $permissions) {
                $permissionsArray = explode(',', $permissions);

                foreach ($permissionsArray as $permissionKey) {
                    // Construct permission name, display_name, and description
                    $permissionName = "{$permissionsMap[$permissionKey]}-{$module}";

                    // Convert to display name: capitalize first letter and replace dashes with spaces
                    $displayName = ucwords(str_replace('-', ' ', $permissionName));

                    $permissionDescription = "Permission to {$permissionsMap[$permissionKey]} in {$module}";

                    // Create or find the permission with name, display_name, and description
                    $permission = Permission::firstOrCreate(
                        ['name' => $permissionName],
                        [
                            'display_name' => $displayName,
                            'description' => $permissionDescription
                        ]
                    );

                    // Display the permission name and description
                    $this->command->info("Permission: {$permission->name}, Display Name: {$permission->display_name}, Description: {$permission->description}");

                    // Add the permission to the array
                    $allPermissions[] = $permission->id;
                }
            }

            // Sync all permissions for the role at once
            $role->permissions()->sync($allPermissions);
        }
    }
}
