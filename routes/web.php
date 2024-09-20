<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
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
    ->as('management.users.') // Name prefix for all routes in this group
    ->group(function () {

        // User Management Dashboard
        Route::get('users', [UserController::class, 'index'])
            ->name('index'); // Named route 'management.users.index'

        // Fetching user data for DataTables with server-side processing
        Route::get('users/data', [UserController::class, 'getUsersData'])
            ->name('data');  // Named route 'management.users.data'

        // Storing user data (create/update)
        Route::post('users/store', [UserController::class, 'store'])
            ->name('store'); // Named route 'management.users.store'

        // Editing user data by ID
        Route::get('users/{id}', [UserController::class, 'edit'])
            ->name('edit');  // Named route 'management.users.edit'

        // Deleting user data by ID
        Route::delete('users/{id}', [UserController::class, 'destroy'])
            ->name('destroy'); // Named route 'management.users.destroy'

        // Changing user password
        Route::post('users/change-password', [UserController::class, 'changePassword'])
            ->name('changePassword'); // Named route 'management.users.changePassword'

        // Fetching user count for each role



    });



Route::prefix('roles')
    ->middleware('auth')
    ->as('roles.') // Set a name prefix for all routes in this group
    ->group(function () {
        // Route for user management dashboard
        Route::get('getRoles', [RoleController::class, 'getRoles'])
            ->name('getRoles'); // Full name will be 'management.users.index'


    });
    Route::post('/upload-profile-picture', [ProfileController::class, 'uploadProfilePicture']);
    Route::post('/remove-profile-picture', [ProfileController::class, 'removePicture'])->name('remove.profile.picture');

Route::post('/verify-superadmin-password', [UserController::class, 'verifySuperadminPassword'])->name('management.verifySuperadminPassword');
