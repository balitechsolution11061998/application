<?php

namespace App\Repositories\Role;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Role;

class RoleRepositoryImplement extends Eloquent implements RoleRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected Role $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

      /**
     * Get all roles with their permissions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRoles()
    {
        return $this->model->with('permissions')->get();
    }

    /**
     * Find a role by its ID.
     *
     * @param int $id
     * @return Role
     */
    public function findRoleById($id)
    {
        return $this->model->with('permissions')->findOrFail($id);
    }

    /**
     * Create a new role.
     *
     * @param array $data
     * @return Role
     */
    public function createRole(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update an existing role.
     *
     * @param Role $role
     * @param array $data
     * @return bool
     */
    public function updateRole($role, array $data)
    {
        return $role->update($data);
    }

    /**
     * Delete a role.
     *
     * @param Role $role
     * @return bool|null
     */
    public function deleteRole($role)
    {
        return $role->delete();
    }
}
