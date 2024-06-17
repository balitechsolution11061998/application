<?php

namespace App\Services\Auth;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\Auth\AuthRepository;
use Illuminate\Support\Facades\Auth;

class AuthServiceImplement extends ServiceApi implements AuthService{

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

    public function checkLogin($username, $password)
    {
        $user = $this->mainRepository->findActiveUserByUsername($username,$password);

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Username tidak ditemukan atau akun tidak aktif!'
            ];
        }

        if (Auth::guard('web')->attempt(['username' => $username, 'password' => $password, 'status' => 'y'])) {
            return [
                'success' => true
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Password salah!'
            ];
        }
    }

}
