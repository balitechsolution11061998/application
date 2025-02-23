<?php

namespace App\Repositories\Login;

use LaravelEasyRepository\Repository;

interface LoginRepository extends Repository
{
    public function findUserByLogin(string $login);
    public function createLoginLog(array $data);
}
