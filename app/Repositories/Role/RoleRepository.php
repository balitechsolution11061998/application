<?php

namespace App\Repositories\Role;

use LaravelEasyRepository\Repository;

interface RoleRepository extends Repository{

    // Write something awesome :)
    public function getAllRoles();
    public function findRoleById($id);
    public function createRole(array $data);
    public function updateRole($role, array $data);
    public function deleteRole($role);
}
