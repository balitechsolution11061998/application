<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
<?php

use App\Http\Controllers\Api\ItemSupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\PoController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\RcvController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TandaTerimaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::post('/supplier/store', [SupplierController::class, 'store']);
Route::post('/stores/store', [StoreController::class, 'store']);
Route::get('/stores/get', [StoreController::class, 'get']);
Route::get('/supplier/get', [SupplierController::class, 'getData']);

Route::post('/po/store', [PoController::class, 'store']);
Route::post('/itemsupplier/store', [ItemSupplierController::class, 'store']);
Route::post('/rcv/store', [RcvController::class, 'store']);
   //rcv get data
   Route::get('/rcv/getData', [RcvController::class, 'getData']);

   //po get data
   Route::get('/po/getData', [PoController::class, 'getData']);

//tanda terima
Route::get('/tanda-terima/getTandaTerima',[TandaTerimaController::class, 'getTandaTerima']);
Route::get('/tanda-terima/cek_tanda_terima',[TandaTerimaController::class, 'cek_tanda_terima']);
Route::get('/tanda-terima/cek_no_antrean_tanda_terima',[TandaTerimaController::class, 'cek_no_antrean_tanda_terima']);
Route::post('/tanda-terima/apporove_in_hosting',[TandaTerimaController::class, 'apporove_in_hosting']);

Route::post('/tanda-terima/update',[TandaTerimaController::class, 'update']);
