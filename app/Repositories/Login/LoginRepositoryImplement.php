<?php

namespace App\Repositories\Login;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\User; // Assuming User is the model for users
use App\Models\LoginLog; // Assuming LoginLog is the model for login logs

class LoginRepositoryImplement extends Eloquent implements LoginRepository
{
    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Find a user by their email or username.
     *
     * @param string $login
     * @return User|null
     */
    public function findUserByLogin(string $login)
    {
        return $this->model->where('email', $login)
            ->orWhere('username', $login)
            ->first();
    }

    /**
     * Create a login log entry.
     *
     * @param array $data
     * @return LoginLog
     */
    public function createLoginLog(array $data)
    {
        return LoginLog::create($data);
    }
}
