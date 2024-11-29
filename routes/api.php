<?php

use App\Http\Controllers\Api\PoController;
use App\Http\Controllers\Api\RcvController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\ItemSupplierController;
use App\Http\Controllers\Api\SupplierController;
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




Route::post('/pr/store', [PurchaseRequisitionController::class, 'store']);
// Supplier Routes
Route::prefix('supplier')->group(function () {
    Route::post('/store', [SupplierController::class, 'store']);
    Route::get('/get', [SupplierController::class, 'getData']);
});

// Store Routes
Route::prefix('stores')->group(function () {
    Route::post('/store', [StoreController::class, 'store']);
    Route::get('/get', [StoreController::class, 'get']);
});

// Purchase Order (PO) Routes
Route::prefix('po')->group(function () {
    Route::post('/store', [PoController::class, 'store']);
    Route::get('/getData', [PoController::class, 'getData']);
});

// Item Supplier Routes
Route::post('/itemsupplier/store', [ItemSupplierController::class, 'store']);

// Receive (RCV) Routes
Route::prefix('rcv')->group(function () {
    Route::post('/store', [RcvController::class, 'store']);
    Route::get('/getData', [RcvController::class, 'getData']);
});
