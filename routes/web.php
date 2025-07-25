<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
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
    return view('frontend.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->controller(AdminController::class)->group(function () {
   Route::get('/admin/dashboard', 'adminDashboard')->name('admin.dashboard');
   Route::get('/admin/logout',  'AdminDestroy')->name('admin.logout');
   Route::get('/admin/profile','adminProfile')->name('admin.profile');
   Route::post('/admin/update/','updateProfile')->name('admin.update');
   Route::get('admin/change/password', 'AdminChangePassword')->name('admin.change.password');
   Route::post('/admin/update-password' , 'AdminUpdatePassword')->name('admin.update.password');
});
Route::get('/admin/login',  [AdminController::class , 'AdminLogin'])->name('admin.login');

Route::middleware(['auth', 'role:service_provider'])->controller(Service_ProviderController::class)->group(function () {
    Route::get('/service_provider/dashboard', 'service_providerDashboard')->name('Service_Provider.dashboard');
    Route::post('/service_provider/update/{id}','updateProfile')->name('Service_Provider.update');
    Route::post('/service_provider/update-password/{id}' , 'UpdatePassword')->name('Service_Provider.update.password');
    Route::post('/service_provider/update-email/{id}' , 'Updateemail')->name('Service_Provider.update.email');
    Route::post('/service_provider/update-phone/{id}' , 'Updatephone')->name('Service_Provider.update.phone');
    Route::get('/service_provider/logout',  'Service_ProviderDestroy')->name('Service_Provider.logout');
});

Route::middleware(['auth', 'role:customer'])->controller(CustomerController::class)->group(function () {
    Route::get('/customer/dashboard', 'customerDashboard')->name('customer.dashboard');
    Route::post('/customer/update/','customerProfileupdate')->name('customer.update');
    Route::post('customer/update-password' , 'customerUpdatePassword')->name('customer.update.password');
    Route::get('/customer/logout',  'customerDestroy')->name('customer.logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
