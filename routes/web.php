<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;

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
Route::get('/', function(){
	return view('welcome');
});

Auth::routes();

Route::get('/formlogin', [LoginController::class, 'index'])->name('formlogin');
Route::post('/formlogin/check_login', [LoginController::class, 'check_login'])->name('formlogin.check_login');
Route::group(['middleware' => ['verifiedmiddleware','twostep','verified','auth','log.user.access']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::prefix('home')->name('home.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/countDataPo', 'HomeController@countDataPo')->name('countDataPo');
        Route::get('/countDataPoPerDays', 'HomeController@countDataPoPerDays')->name('countDataPoPerDays');
        Route::get('/countDataRcv', 'HomeController@countDataRcv')->name('countDataRcv');
        Route::get('/countDataRcvPerDays', 'HomeController@countDataRcvPerDays')->name('countDataRcvPerDays');
    });

    Route::prefix('po')->name('po.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/', 'OrdHeadController@index')->name('index');
        Route::get('/data', 'OrdHeadController@data')->name('data');

    });

    Route::prefix('permissions')->name('permissions.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/', 'PermissionsController@index')->name('index');
        Route::get('/data', 'PermissionsController@data')->name('data');
        Route::post('/store', 'PermissionsController@store')->name('store');
        Route::get('{id}/edit', 'PermissionsController@edit')->name('data');
        Route::get('{id}/edit', 'PermissionsController@edit')->name('data');
        Route::delete('/delete', 'PermissionsController@delete')->name('delete');
        Route::get('/getAllPermissions', 'PermissionsController@getAllPermissions')->name('getAllPermissions');
        Route::post('/submitToRole', 'PermissionsController@submitToRole')->name('submitToRole');
        Route::get('/getPermissionsByRole', 'PermissionsController@getPermissionsByRole')->name('getPermissionsByRole');
    });

    Route::prefix('roles')->name('roles.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/', 'RoleController@index')->name('index');
        Route::get('/data', 'RoleController@data')->name('data');
        Route::post('/store', 'RoleController@store')->name('store');
        Route::get('/{id}/edit', 'RoleController@edit')->name('edit');
        Route::delete('/delete', 'RoleController@delete')->name('delete');
        Route::get('/getAllRoles', 'RoleController@getAllRoles')->name('getAllRoles');
        Route::post('/submitRolesToUser', 'RoleController@submitRolesToUser')->name('submitRolesToUser');
        Route::get('/getRolesByUser', 'RoleController@getRolesByUser')->name('getRolesByUser');
    });

    Route::prefix('users')->name('users.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/', 'UserController@index')->name('index');
        Route::get('/create', 'UserController@create')->name('create');
        Route::post('/store','UserController@store')->name('store');
        Route::get('/data', 'UserController@data')->name('data');
        Route::post('/reset-password/{id}', 'UserController@resetPassword')->name('reset-password');
        Route::get('/{id}/edit', 'UserController@edit')->name('edit');
        Route::get('/{id}/dataEdit', 'UserController@dataEdit')->name('dataEdit');


    });

    Route::prefix('departments')->name('departments.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/data', 'DepartmentController@data')->name('data');
    });

    Route::prefix('provinsi')->name('provinsi.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/data', 'ProvinsiController@data')->name('data');
    });

    Route::prefix('kabupaten')->name('kabupaten.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/data', 'KabupatenController@data')->name('data');
    });

    Route::prefix('kecamatan')->name('kecamatan.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/data', 'KecamatanController@data')->name('data');
    });

    Route::prefix('kelurahan')->name('kelurahan.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/data', 'KelurahanController@data')->name('data');
    });

    Route::prefix('jabatan')->name('jabatan.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/data', 'JabatanController@data')->name('data');
    });
});






