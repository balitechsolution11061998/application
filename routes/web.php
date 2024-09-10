<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::controller(RegisterController::class)->group(function () {
    Route::get('register', 'showRegisterForm')->name('register');
    Route::post('register', 'register');
});
Route::get('login/form', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('login/prosesForm', [LoginController::class, 'login'])->name('login.prosesForm');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/home', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth'); // 'role' is provided by Laratrust


Route::prefix('management')
    ->middleware('auth')
    ->as('management.users.') // Set a name prefix for all routes in this group
    ->group(function () {
        // Route for user management dashboard
        Route::get('users', [UserController::class, 'index'])
            ->name('index'); // Full name will be 'management.users.index'

        // Route for fetching user data with server-side processing
        Route::get('users/data', [UserController::class, 'getUsersData'])
            ->name('data');  // Full name will be 'management.users.data'
    });

Route::post('/verify-superadmin-password', [UserController::class, 'verifySuperadminPassword'])->name('management.verifySuperadminPassword');
