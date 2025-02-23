<?php

namespace App\Services\Role;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\Role\RoleRepository;

class RoleServiceImplement extends ServiceApi implements RoleService{

    /**
     * set title message api for CRUD
     * @param string $title
     */
     protected string $title = "";
     /**
     * uncomment this to override the default message
     * protected string $create_message = "";
     * protected string $update_message = "";
     * protected string $delete_message = "";
     */

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected RoleRepository $mainRepository;

    public function __construct(RoleRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
    public function getAllRoles()
    {
        return $this->mainRepository->getAllRoles();
    }

    public function createRole(array $data)
    {
        return $this->mainRepository->createRole($data);
    }

    public function updateRole($role, array $data)
    {
        return $this->mainRepository->updateRole($role, $data);
    }

    public function deleteRole($role)
    {
        return $this->mainRepository->deleteRole($role);
    }
}
