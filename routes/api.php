<?php

use App\Http\Controllers\Api\PoController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\ItemSupplierController;
use App\Http\Controllers\PurchaseRequisitionController;
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



Route::post('/po/store', [PoController::class, 'store']);
Route::post('/itemsupplier/store', [ItemSupplierCcontroller::class, 'store']);
Route::post('/pr/store', [PurchaseRequisitionController::class, 'store']);
Route::post('/stores/store', [StoreController::class, 'store']);
