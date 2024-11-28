<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardPilkadaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KelurahanController;
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

Route::get('/activities/data', [ActivityController::class, 'getData'])->name('activities.data');
Route::get('/get-ram-usage', [SystemUsageController::class, 'getRamUsageData'])->name('ramUsageData');

Route::get('login/form', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('login/prosesForm', [LoginController::class, 'login'])->name('login.prosesForm');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
// Home route with 'auth' middleware and role check (Laratrust)
Route::get('/home', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');

// Grouping Management User routes under 'management/users'
Route::prefix('/users')
    ->middleware('auth')
    ->as('users.') // Set a name prefix for all routes in this group
    ->group(function () {
        // User Management Dashboard
        Route::get('/', [UserController::class, 'index'])
            ->name('index'); // 'management.users.index'

        // Fetching user data for DataTables
        Route::get('/data', [UserController::class, 'getUsersData'])
            ->name('data'); // 'management.users.data'

        // Store user data (create/update)
        Route::post('/store', [UserController::class, 'store'])
            ->name('store'); // 'management.users.store'

        // Edit user data by ID
        Route::get('/{id}/edit', [UserController::class, 'edit'])
            ->name('edit'); // 'management.users.edit'

        // Delete user data by ID
        Route::delete('/{id}', [UserController::class, 'destroy'])
            ->name('destroy'); // 'management.users.destroy'

        // Change user password
        Route::post('/change-password', [UserController::class, 'changePassword'])
            ->name('changePassword'); // 'management.users.changePassword'

        // User profile
        Route::get('/profile', [UserController::class, 'profile'])
            ->name('profile'); // 'management.users.profile'

        Route::post('/add-email', [UserController::class, 'addEmail'])
            ->name('add-email'); // 'management.users.changePassword'

        Route::post('/delete-email', [UserController::class, 'deleteEmail'])
            ->name('delete-email'); // 'management.users.changePassword'

        Route::post('/rolesdelete', [UserController::class, 'deleteRole'])
            ->name('deleteRole'); // 'management.users.changePassword'


        Route::get('/{id}/addstore', [UserController::class, 'addStore'])->name('addstore');
        Route::get('/{id}/addemail', [UserController::class, 'addEmailView'])->name('addEmailView');
        Route::get('/{id}/formUser', [UserController::class, 'formUser'])->name('formUser');


    });

Route::prefix('dashboard-pilkada')
    ->middleware('auth')
    ->as('dashboard-pilkada.')
    ->group(function () {
        // Dashboard Pilkada main route
        Route::get('/', [DashboardPilkadaController::class, 'index'])->name('index');

        // Additional routes related to Dashboard Pilkada
        Route::get('/fetchData', [DashboardPilkadaController::class, 'fetchData'])->name('fetchData');
    });



// Role management routes
Route::prefix('roles')
    ->middleware('auth')
    ->as('roles.')
    ->group(function () {
        // Fetch roles data
        Route::get('/getRoles', [RoleController::class, 'getRoles'])->name('getRoles');
        Route::get('/data', [RoleController::class, 'data'])->name('data');

        // Standard CRUD routes for Roles
        Route::resource('/', RoleController::class)->parameters(['' => 'role'])->except(['show']);
    });



Route::resource('tahun-pelajaran', TahunPelajaranController::class);
Route::get('tahun-pelajaran/data', [TahunPelajaranController::class, 'getData'])->name('tahun-pelajaran.getData');

Route::prefix('rooms')
    ->middleware('auth')
    ->as('rooms.')
    ->group(function () {
        // Additional endpoints for fetching room data if needed
        Route::get('/data', [RoomController::class, 'data'])->name('data');

        // Standard CRUD routes for Rooms, excluding show route
        Route::resource('/', RoomController::class)
            ->parameters(['' => 'room'])
            ->except(['show']);
    });

Route::prefix('permissions')
    ->middleware(['auth'])  // Middleware to ensure the user is authenticated
    ->as('permissions.')    // Route name prefix for easier reference
    ->group(function () {
        Route::resource('/', PermissionController::class)->except(['show'])->parameters(['' => 'permission']);

        // Additional route for DataTables AJAX request
        Route::get('/data', [PermissionController::class, 'data'])->name('data');
    });


Route::prefix('suppliers')
    ->middleware(['auth']) // Ensure user authentication
    ->as('suppliers.')     // Route name prefix for suppliers
    ->group(function () {
        // Route for importing suppliers via CSV/XLSX
        Route::post('/import', [UserController::class, 'import'])->name('import');
    });

Route::prefix('stores')
    ->middleware(['auth']) // Ensure user authentication
    ->as('stores.')     // Route name prefix for suppliers
    ->group(function () {
        // Route for importing suppliers via CSV/XLSX
        Route::post('/storeUser', [StoreController::class, 'storeUser'])->name('storeUser');
        Route::post('/deleteStoreUser', [StoreController::class, 'deleteStoreUser'])->name('deleteStoreUser');

    });

Route::prefix('regions')
    ->middleware('auth')
    ->as('regions.') // Set a name prefix for all role routes
    ->group(function () {
        // Fetch roles data
        Route::get('/data', [RegionController::class, 'data'])
            ->name('data'); // 'roles.getRoles'
    });

Route::prefix('purchase-orders') // Prefix for all order routes
    ->middleware('auth') // Ensure the user is authenticated
    ->as('purchase-orders.') // Prefix for route names
    ->group(function () {
        // Fetch orders data
        Route::get('/getOrders', [OrderController::class, 'getOrders'])->name('getOrders');
        Route::get('/data', [OrderController::class, 'data'])->name('data');

        // Standard CRUD routes for Orders
        Route::resource('/', OrderController::class)->parameters(['' => 'order'])->except(['show']);
        Route::post('/store', [OrderController::class, 'store']);
        Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('edit');
        Route::get('/show/{id}', [OrderController::class, 'show'])->name('show');

    });

// Profile Picture management routes
Route::post('/upload-profile-picture', [ProfileController::class, 'uploadProfilePicture']);
Route::post('/remove-profile-picture', [ProfileController::class, 'removePicture'])
    ->name('remove.profile.picture');

// Verify Superadmin password route
Route::post('/verify-superadmin-password', [UserController::class, 'verifySuperadminPassword'])
    ->name('management.verifySuperadminPassword');
Route::get('/docs', function () {
    return view('docs.index'); // File Markdown bisa Anda buat di sini
});
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
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
