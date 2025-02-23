<?php

namespace App\Services\Login;

use LaravelEasyRepository\BaseService;
use Illuminate\Http\Request;

interface LoginService extends BaseService
{
    public function validateLogin(Request $request);
    public function attemptLogin(Request $request);
    public function logFailedLogin(Request $request);
    public function logEvent($user, $event, Request $request);
    public function logError(Request $request, $errorMessage);
}
