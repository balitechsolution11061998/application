<?php

namespace App\Services\Permission;

use LaravelEasyRepository\BaseService;

interface PermissionService extends BaseService
{
    public function getAllForDataTable();
}
