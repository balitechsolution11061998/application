<?php

namespace App\Services\Role;

use LaravelEasyRepository\BaseService;

interface RoleService extends BaseService{

    // Write something awesome :)
    public function getAllRoles();
    public function createRole(array $data);
    public function updateRole($role, array $data);
    public function deleteRole($role);
}
