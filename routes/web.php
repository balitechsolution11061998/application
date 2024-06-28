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
Route::get('/welcome', function(){
	return view('welcome');
});

Auth::routes();

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login/check_login', [LoginController::class, 'check_login'])->name('login.check_login');
Route::group(['middleware' => ['verifiedmiddleware','verified','auth','log.user.access']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::prefix('home')->name('home.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/countDataPo', 'HomeController@countDataPo')->name('countDataPo');
        Route::get('/countDataPoPerDays', 'HomeController@countDataPoPerDays')->name('countDataPoPerDays');
        Route::get('/countDataRcv', 'HomeController@countDataRcv')->name('countDataRcv');
        Route::get('/countDataRcvPerDays', 'HomeController@countDataRcvPerDays')->name('countDataRcvPerDays');
    });

    Route::prefix('po')->name('po.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/index', 'OrdHeadController@index')->name('index');
        Route::get('/data', 'OrdHeadController@data')->name('data');

    });

    Route::prefix('users')->name('users.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/index', 'UserController@index')->name('index');
    });

    Route::prefix('departments')->name('departments.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/data', 'DepartmentController@data')->name('data');
    });

});






