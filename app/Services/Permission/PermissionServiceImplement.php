<?php

namespace App\Services\Permission;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\Permission\PermissionRepository;

class PermissionServiceImplement extends ServiceApi implements PermissionService
{
    protected PermissionRepository $mainRepository;

    public function __construct(PermissionRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function getAllForDataTable()
    {
        return $this->mainRepository->all(['id', 'name', 'display_name', 'description', 'created_at']);
    }
}
