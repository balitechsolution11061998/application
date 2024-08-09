<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\QueryPerformanceLogController;
use App\Http\Controllers\WebsiteController;
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


Auth::routes();
Route::get('/scanbarcode', function(){
    return view('auth.scanbarcode');
});
Route::get('/', [LoginController::class, 'index'])->name('logincbt');
// Route::get('/logincbt', [LoginController::class, 'index1'])->name('logincbt');

Route::post('/formlogin/check_login', [LoginController::class, 'check_login'])->name('formlogin.check_login');
Route::post('/login-with-qr', [LoginController::class, 'loginWithQrCode']);

Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/callback/google', [LoginController::class, 'handleGoogleCallback']);
Route::get('/website', [WebsiteController::class, 'index'])->name('website');

Route::group(['middleware' => ['verifiedmiddleware','verified','auth','log.user.access', 'online']], function () {

// Route::group(['middleware' => ['verifiedmiddleware','twostep','verified','auth','log.user.access']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home/epresensi', [HomeController::class, 'index3'])->name('home.epresensi');
    Route::get('/home/cbt', [HomeController::class, 'index2'])->name('home.cbt');
    Route::get('/performance-data', [PerformanceController::class, 'getPerformanceData']);

    Route::prefix('home')->name('home.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/countDataPo', 'HomeController@countDataPo')->name('countDataPo');
        Route::get('/countDataPoPerDays', 'HomeController@countDataPoPerDays')->name('countDataPoPerDays');
        Route::get('/countDataRcv', 'HomeController@countDataRcv')->name('countDataRcv');
        Route::get('/countDataRcvPerDays', 'HomeController@countDataRcvPerDays')->name('countDataRcvPerDays');
        Route::get('/countDataPoPerDate', 'HomeController@countDataPoPerDate')->name('countDataPoPerDate');
    });

    Route::prefix('po')->name('po.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/', 'OrdHeadController@index')->name('index');
        Route::get('/data', 'OrdHeadController@data')->name('data');
        Route::get('/download', 'OrdHeadController@download')->name('download');
        Route::get('/count', 'OrdHeadController@count')->name('count');
        Route::get('/delivery', 'OrdHeadController@delivery')->name('delivery');
        Route::post('/store', 'OrdHeadController@store')->name('store');
        Route::get('/progress', 'OrdHeadController@getProgress')->name('getProgress');
        Route::get('/getOrderDetails', 'OrdHeadController@getOrderDetails')->name('getProgress');

    });


    Route::prefix('price-change')->name('price-change.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/', 'PriceChangeController@index')->name('index');
        Route::get('/data', 'PriceChangeController@data')->name('data');
        Route::get('/download', 'PriceChangeController@download')->name('download');
        Route::post('/upload', 'PriceChangeController@upload')->name('upload');
        Route::get('/{id}/show', 'PriceChangeController@show')->name('show');
        Route::post('/store', 'PriceChangeController@store')->name('store');
        Route::get('/count', 'PriceChangeController@count')->name('count');
        Route::post('/approve', 'PriceChangeController@approve')->name('approve');
        Route::post('/reject', 'PriceChangeController@reject')->name('reject');


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
        Route::delete('/delete/{id}','UserController@delete')->name('delete');
        Route::post('/send-account-details', 'UserController@sendAccountDetails');
        Route::get('/konfigurasi/{nik}/setjamkerja', 'UserController@setjamkerja');
        Route::post('/konfigurasi/store', 'UserController@konfigurasiStore');
        Route::post('/konfigurasi/storeByDate', 'UserController@storeByDate');
        Route::get('/{userId}/generate-qr-code', 'UserController@generateQRCode');
        Route::get('/profile', 'UserController@profile')->name('dataEdit');
        Route::get('/{userId}/download-qr-code-pdf', 'UserController@downloadQRCodePDF');


    });

    Route::prefix('departments')->name('departments.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/index', 'DepartmentController@index')->name('index');
        Route::get('/data', 'DepartmentController@data')->name('data');
        Route::get('/getData', 'DepartmentController@getData')->name('getData');
        Route::get('/count', 'DepartmentController@count');
        Route::post('/store', 'DepartmentController@store')->name('store');
        Route::get('/{id}/edit', 'DepartmentController@edit')->name('edit');
        Route::delete('/{id}/delete', 'DepartmentController@delete')->name('delete');
        Route::get('/getDepartments', 'DepartmentController@getDepartments')->name('getDepartments');


    });

    Route::prefix('kantor_cabang')->name('kantor_cabang.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/index', 'KantorCabangController@index')->name('index');
        Route::get('/data', 'KantorCabangController@data')->name('data');
        Route::get('/getData', 'KantorCabangController@getData')->name('getData');
        Route::post('/store', 'KantorCabangController@store')->name('store');
        Route::get('/{id}/edit', 'KantorCabangController@edit')->name('edit');
        Route::delete('/{id}/delete', 'KantorCabangController@delete')->name('delete');
    });

    Route::prefix('cuti')->name('cuti.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/index', 'CutiController@index')->name('index');
        Route::get('/data', 'CutiController@data')->name('data');
        Route::get('/count', 'CutiController@count')->name('count');
        Route::post('/store', 'CutiController@store')->name('store');
        Route::get('/{id}/edit', 'CutiController@edit')->name('edit');
        Route::delete('/{id}/delete', 'CutiController@delete')->name('delete');
    });

    Route::prefix('items')->name('items.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/', 'ItemsController@index')->name('index');
        Route::get('/data', 'ItemsController@data')->name('data');
        Route::get('/getDataItemSupplierBySupplier', 'ItemsController@getDataItemSupplierBySupplier')->name('getDataItemSupplierBySupplier');

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

    Route::prefix('cabang')->name('cabang.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/data', 'CabangController@data')->name('data');
        Route::get('/count', 'CabangController@count')->name('count');
    });

    Route::prefix('settings')->name('settings.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/price-change/index', 'SettingsController@priceChange')->name('priceChange.index');
        Route::get('/price-change/data', 'SettingsController@approvalPriceChangeData')->name('priceChange.data');
        Route::post('/price-change/store', 'SettingsController@priceChangeStore')->name('priceChangeStore');

    });


    Route::prefix('paket-soal')->name('paket-soal.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/index', 'PaketSoalController@index')->name('index');
        Route::get('/data', 'PaketSoalController@data')->name('data');
        Route::post('/store', 'PaketSoalController@store')->name('store');
        Route::get('{id}/edit', 'PaketSoalController@edit')->name('edit');
        Route::post('/update/{id}', 'PaketSoalController@update')->name('update');
        Route::delete('/delete/{id}', 'PaketSoalController@destroy')->name('destroy');
        Route::get('/options', 'PaketSoalController@dataoptions')->name('options');

    });

    Route::prefix('store')->name('store.')->namespace('App\Http\Controllers')->group(function () {
        Route::post('/store', 'StoreController@store')->name('store');

    });

    Route::prefix('supplier')->name('supplier.')->namespace('App\Http\Controllers')->group(function () {
        Route::post('/store', 'SupplierController@store')->name('store');

    });


    Route::prefix('jam_kerja')->name('jam_kerja.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/index', 'JamKerjaController@index')->name('index');
        Route::get('/data', 'JamKerjaController@data')->name('data');
        Route::post('/store', 'JamKerjaController@store')->name('store');
        Route::get('/edit/{id}', 'JamKerjaController@edit')->name('edit');
        Route::delete('/delete/{id}', 'JamKerjaController@delete')->name('edit');

    });

    Route::prefix('rcv')->name('rcv.')->namespace('App\Http\Controllers')->group(function () {
        Route::post('/store', 'RcvController@store')->name('store');
        Route::get('/progress', 'RcvController@getProgress')->name('getProgress');
    });

    Route::prefix('kelas')->name('kelas.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/index', 'KelasController@index')->name('index');
        Route::get('/data', 'KelasController@data')->name('data');
        Route::post('/store', 'KelasController@store')->name('store');
        Route::get('{id}/edit', 'KelasController@edit')->name('edit');
        Route::delete('/delete/{id}', 'KelasController@destroy')->name('destroy');
        Route::get('/options', 'KelasController@dataoptions')->name('options');
        Route::get('/getKelasData', 'KelasController@getKelasData');

    });

    Route::prefix('rombel')->name('rombel.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/index', 'RombelController@index')->name('index');
        Route::get('/data', 'RombelController@data')->name('data');
        Route::post('/store', 'RombelController@store')->name('store');
        Route::get('{id}/edit', 'RombelController@edit')->name('edit');
        Route::delete('/delete/{id}', 'RombelController@destroy')->name('destroy');
        Route::get('/options', 'RombelController@getRombelOptions')->name('getRombelOptions');
        Route::get('/getRombelData', 'RombelController@getRombelData')->name('getRombelData');

    });

    Route::prefix('siswa')->name('siswa.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/index', 'SiswaController@index')->name('index');
        Route::get('/data', 'SiswaController@data')->name('data');
        Route::get('/getStudentData', 'SiswaController@getStudentData')->name('getStudentData');
        Route::post('/store', 'SiswaController@store')->name('store');
        Route::get('{id}/edit', 'SiswaController@edit')->name('edit');
        Route::delete('/delete/{id}', 'SiswaController@destroy')->name('destroy');
    });

    Route::prefix('mata-pelajaran')->name('mata-pelajaran.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/index', 'MataPelajaranController@index')->name('index');
        Route::get('/data', 'MataPelajaranController@data')->name('data');
        Route::post('/store', 'MataPelajaranController@store')->name('store');
        Route::get('{id}/edit', 'MataPelajaranController@edit')->name('edit');
        Route::post('/update/{id}', 'MataPelajaranController@update')->name('update');
        Route::delete('/delete/{id}', 'MataPelajaranController@destroy')->name('destroy');
        Route::get('/options', 'MataPelajaranController@dataoptions')->name('options');
        Route::get('/getMataPelajaranData', 'MataPelajaranController@getMataPelajaranData')->name('getMataPelajaranData');

    });

    Route::prefix('soal')->name('soal.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/index', 'ManagementSoalController@index')->name('index');
        Route::get('/data', 'ManagementSoalController@data')->name('data');
        Route::post('/store', 'ManagementSoalController@store')->name('store');
        Route::get('{id}/edit', 'ManagementSoalController@edit')->name('edit');
        Route::post('/update/{id}', 'ManagementSoalController@update')->name('update');
        Route::delete('/delete/{id}', 'ManagementSoalController@destroy')->name('destroy');
        Route::get('/options', 'ManagementSoalController@dataoptions')->name('options');
    });

    Route::prefix('ujian')->name('ujian.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/index', 'UjianController@index')->name('index');
        Route::get('/data', 'UjianController@data')->name('data');
        Route::post('/store', 'UjianController@store')->name('store');
        Route::get('{id}/edit', 'UjianController@edit')->name('edit');
        Route::post('/update/{id}', 'UjianController@update')->name('update');
        Route::delete('/delete/{id}', 'UjianController@destroy')->name('destroy');
        Route::get('/options', 'UjianController@dataoptions')->name('options');
        Route::get('/start/{ujian_id}/{nis}/{paketSoal_id}', 'UjianController@start')->name('start');
        Route::get('/show', 'UjianController@show')->name('show');
        Route::post('/end', 'UjianController@end')->name('end');
        Route::get('/hasil-ujian/{id}', 'UjianController@showHasilUjian')->name('hasil-ujian');
        Route::get('/fetchHistory', 'UjianController@fetchHistory')->name('fetchHistory');
    });

    Route::prefix('monitoring-presensi')->name('monitoring-presensi.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/index', 'MonitoringPresensiController@index')->name('index');
        Route::get('/data', 'MonitoringPresensiController@data')->name('data');

    });

    Route::prefix('izin')->name('izin.')->namespace('App\Http\Controllers')->group(function () {
        Route::get('/index', 'IzinController@index')->name('index');
        Route::get('/data', 'IzinController@data')->name('data');
        Route::get('/{id}/show','IzinController@show')->name('show');
        Route::post('/{id}/approve', 'IzinController@approve')->name('izin.approve');
        Route::post('/{id}/reject', 'IzinController@reject')->name('izin.reject');
    });

    Route::get('/query-performance-logs', [QueryPerformanceLogController::class, 'getLogs']);
    Route::get('/query-performance-logs/chart-data', [QueryPerformanceLogController::class, 'getChartData']);

    Route::get('/notifications', [NotificationController::class, 'fetchNotifications'])->name('notifications.fetch');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    Route::get('/get-existing-chats', [ChatController::class, 'getExistingChats'])->name('get-existing-chats');
    Route::get('/search-users', [ChatController::class, 'searchUsers'])->name('search.users');
    Route::get('/chat/{user}', [ChatController::class, 'getChat'])->name('get.chat');
    Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('send.message');

});






