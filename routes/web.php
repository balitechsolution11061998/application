<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardPilkadaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemSupplierController;
use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KelurahanController;
use App\Http\Controllers\OpenAIController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SyncDataController;
use App\Http\Controllers\SystemUsageController;
use App\Http\Controllers\TahunPelajaranController;
use App\Http\Controllers\TpsController;
use App\Http\Controllers\UserController;
use App\Models\ItemSupplier;
use Illuminate\Support\Facades\Route;

// Web Routes
Route::get('/', fn() => view('welcome'));

// Authentication Routes
Route::controller(RegisterController::class)->group(function () {
    Route::get('register', 'showRegisterForm')->name('register');
    Route::post('register', 'register');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('login/form', 'showLoginForm')->name('login.form');
    Route::post('login/prosesForm', 'login')->name('login.prosesForm');
    Route::post('logout', 'logout')->name('logout');
});

Route::get('/koperasi', fn() => view('koperasi'));


// Home Route

// Grouping Authenticated Routes
Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // User Management Routes
    Route::prefix('users')->as('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/data', [UserController::class, 'getUsersData'])->name('data');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        Route::post('/change-password', [UserController::class, 'changePassword'])->name('changePassword');
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::post('/add-email', [UserController::class, 'addEmail'])->name('add-email');
        Route::post('/delete-email', [UserController::class, 'deleteEmail'])->name('delete-email');
        Route::post('/rolesdelete', [UserController::class, 'deleteRole'])->name('deleteRole');
        Route::get('/{id}/addstore', [UserController::class, 'addStore'])->name('addstore');
        Route::get('/{id}/addemail', [UserController::class, 'addEmailView'])->name('addEmailView');
        Route::get('/{id}/formUser', [UserController::class, 'formUser'])->name('formUser');
    });

    // Dashboard Pilkada Routes
    Route::prefix('dashboard-pilkada')->as('dashboard-pilkada.')->group(function () {
        Route::get('/', [DashboardPilkadaController::class, 'index'])->name('index');
        Route::get('/fetchData', [DashboardPilkadaController::class, 'fetchData'])->name('fetchData');
    });

    // Role Management Routes
    Route::prefix('roles')->as('roles.')->group(function () {
        Route::get('/getRoles', [RoleController::class, 'getRoles'])->name('getRoles');
        Route::get('/data', [RoleController::class, 'data'])->name('data');
        Route::resource('/', RoleController::class)->parameters(['' => 'role'])->except(['show']);
    });

    Route::prefix('activities')->as('activities.')->group(function () {
        Route::get('/data', [ActivityController::class, 'getData'])->name('data');
    });

    // Tahun Pelajaran Routes
    Route::resource('tahun-pelajaran', TahunPelajaranController::class);
    Route::get('tahun-pelajaran/data', [TahunPelajaranController::class, 'getData'])->name('tahun-pelajaran.getData');

    // Room Management Routes
    Route::prefix('rooms')->as('rooms.')->group(function () {
        Route::get('/data', [RoomController::class, 'data'])->name('data');
        Route::resource('/', RoomController::class)->parameters(['' => 'room'])->except(['show']);
    });

    // Permission Management Routes
    Route::prefix('permissions')->as('permissions.')->group(function () {
        Route::resource('/', PermissionController::class)->except(['show'])->parameters(['' => 'permission']);
        Route::get('/data', [PermissionController::class, 'data'])->name('data');
    });

    // Supplier Management Routes
    Route::prefix('suppliers')->as('suppliers.')->group(function () {
        Route::post('/import', [UserController::class, 'import'])->name('import');
    });

    // Store Management Routes
    Route::prefix('stores')->as('stores.')->group(function () {
        Route::post('/storeUser', [StoreController::class, 'storeUser'])->name('storeUser');
        Route::post('/deleteStoreUser', [StoreController::class, 'deleteStoreUser'])->name('deleteStoreUser');
    });

    // Region Management Routes
    Route::prefix('regions')->as('regions.')->group(function () {
        Route::get('/data', [RegionController::class, 'data'])->name('data');
    });

    // Purchase Orders Routes
    Route::prefix('purchase-orders')->as('purchase-orders.')->group(function () {
        Route::get('/getOrders', [OrderController::class, 'getOrders'])->name('getOrders');
        Route::get('/data', [OrderController::class, 'data'])->name('data');
        Route::post('/store', [OrderController::class, 'store'])->name('store');
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/show/{id}', [OrderController::class, 'show'])->name('show');
    });

    Route::prefix('item-suppliers')->as('item-suppliers.')->group(function () {
        Route::get('/index', [ItemSupplierController::class, 'index'])->name('index');
        Route::get('/data', [ItemSupplierController::class, 'data'])->name('data');
        Route::post('/store', [ItemSupplierController::class, 'store'])->name('store');
    });

    // Profile Picture Management Routes
    Route::post('/upload-profile-picture', [ProfileController::class, 'uploadProfilePicture']);
    Route::post('/remove-profile-picture', [ProfileController::class, 'removePicture'])->name('remove.profile.picture');

    // Superadmin Verification Route
    Route::post('/verify-superadmin-password', [UserController::class, 'verifySuperadminPassword'])->name('management.verifySuperadminPassword');

    // Sync Routes for Provinces, Kabupaten, Kecamatan, Kelurahan, TPS, and Pilkada
    Route::get('/sync-provinces', [ProvinceController::class, 'syncProvinces']);
    Route::get('/data-provinces', [ProvinceController::class, 'dataProvinces']);
    Route::get('/sync-kabupaten/{province}', [KabupatenController::class, 'syncKabupaten']);
    Route::get('/data-kabupaten', [KabupatenController::class, 'dataKabupaten']);
    Route::get('/sync-kecamatan/{provinceId}/{kabupatenId}', [KecamatanController::class, 'syncKecamatan']);
    Route::get('/data-kecamatan', [KecamatanController::class, 'dataKecamatan']);
    Route::get('/sync-kelurahan/{provinceId}/{kabupatenId}/{kecamatanId}', [KelurahanController::class, 'syncKelurahan']);
    Route::get('/data-kelurahan', [KelurahanController::class, 'dataKelurahan']);
    Route::get('/sync-tps/{provinceId}/{kabupatenId}/{kecamatanId}/{kelurahanId}', [TpsController::class, 'syncTps']);
    Route::get('/data-tps', [TpsController::class, 'dataTps']);
    Route::get('/sync-pilkada/{provinceId}/{kabupatenId}/{kecamatanId}/{kelurahanId}/{tpsId}', [SyncDataController::class, 'syncDataPemilihan']);
    Route::get('/data-pilkada', [SyncDataController::class, 'dataPilkada']);
});
Route::post('/generate', [OpenAIController::class, 'generate']);

// Documentation Route
Route::get('/docs', fn() => view('docs.index'));



// Laravel File Manager Routes
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
