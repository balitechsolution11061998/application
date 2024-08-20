<?php

namespace App\Repositories\Auth;

use LaravelEasyRepository\Repository;

interface AuthRepository extends Repository{
    public function findUserByUsername($username);
}
