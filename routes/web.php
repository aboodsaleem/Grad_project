<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Service_ProviderController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->controller(AdminController::class)->group(function () {

    Route::prefix('admin')->name('admin.')->group(function() {
        //Admin Route
    Route::get('/dashboard', 'adminDashboard')->name('dashboard');
    Route::get('/logout',  'AdminDestroy')->name('logout');
    Route::get('/profile','adminProfile')->name('profile');
    Route::post('/update','updateProfile')->name('update');
    Route::get('/change/password', 'AdminChangePassword')->name('change.password');
    Route::post('/update-password' , 'AdminUpdatePassword')->name('update.password');
    //Users Route
    Route::get('users', [AdminController::class , 'admin_users'])->name('users.list');
    Route::get('users/view/{id}', [AdminController::class , 'admin_users_view'])->name('users.view');
    Route::delete('users/{id}/soft-delete', [AdminController::class, 'softDelete'])->name('users.softDelete');
    Route::delete('users/{id}/force-delete', [AdminController::class, 'forceDelete'])->name('users.forceDelete');
    Route::put('users/{id}/restore', [AdminController::class, 'restore'])->name('users.restore');
    Route::get('users/trashed', [AdminController::class, 'trashed'])->name('users.trashed');

    //Categories Route

    Route::resource('categories', CategoryController::class);
    // routes/web.php (داخل مجموعة admin)
Route::get('categories/trashed', [CategoryController::class, 'trashed'])->name('categories.trashed');
Route::delete('categories/{id}/soft-delete', [CategoryController::class, 'softDelete'])->name('categories.softDelete');
Route::put('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
Route::delete('categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');





});
});
Route::get('/admin/login',  [AdminController::class , 'AdminLogin'])->name('admin.login');

Route::middleware(['auth', 'role:service_provider'])->controller(Service_ProviderController::class)->group(function () {
    Route::get('/service_provider/dashboard', 'service_providerDashboard')->name('Service_Provider.dashboard');
    Route::get('/service_provider/profile','service_providerProfile')->name('Service_Provider.profile');
    Route::post('/service_provider/update/','updateProfile')->name('Service_Provider.update');
    Route::get('service_provider/change/password', 'ChangePassword')->name('Service_Provider.change.password');
    Route::post('/service_provider/update-password' , 'UpdatePassword')->name('Service_Provider.update.password');
    Route::get('/service_provider/logout',  'Service_ProviderDestroy')->name('Service_Provider.logout');
});
Route::get('/service_provider/login',  [Service_ProviderController::class , 'service_providerlogin'])->name('Service_Provider.login');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
