<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
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
Route::get('/', function(){
	return view('welcome');
});


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login/check_login', [LoginController::class, 'check_login'])->name('login.check_login');
Route::group(['middleware' => ['verifiedmiddleware','verified','auth','log.user.access']], function () {
    Route::prefix('home')->name('home.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/index', 'HomeController@index')->name('index');
        Route::get('/countDataPo', 'HomeController@countDataPo')->name('countDataPo');
        Route::get('/countDataPoPerDays', 'HomeController@countDataPoPerDays')->name('countDataPoPerDays');
        Route::get('/countDataRcv', 'HomeController@countDataRcv')->name('countDataRcv');
        Route::get('/countDataRcvPerDays', 'HomeController@countDataRcvPerDays')->name('countDataRcvPerDays');
    });
});

Route::get('/dashboard', function(){
	return redirect()->route('example');
})->name('dashboard');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
