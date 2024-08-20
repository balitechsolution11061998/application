<?php

namespace App\Services\Auth;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\Auth\AuthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthServiceImplement extends ServiceApi implements AuthService
{

    /**
     * set title message api for CRUD
     * @param string $title
     */
    protected $title = "";
    /**
     * uncomment this to override the default message
     * protected $create_message = "";
     * protected $update_message = "";
     * protected $delete_message = "";
     */

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(AuthRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function checkLogin($username, $password, $remember_me)
    {
        // Find the user by username regardless of status
        $user = $this->mainRepository->findUserByUsername($username);

        // If the user exists, check if the status is 'y'
        if ($user) {
            if ($user->status !== 'y') {
                return ['success' => false, 'message' => 'Account is inactive. Please contact support.'];
            }

            // If the password matches
            if (Hash::check($password, $user->password)) {
                // Log in the user with the "remember me" option
                Auth::login($user, $remember_me);
                return ['success' => true];
            } else {
                return ['success' => false, 'message' => 'Invalid credentials.'];
            }
        } else {
            return ['success' => false, 'message' => 'User not found.'];
        }
    }

}
