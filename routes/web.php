<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceProvider\Service_ProviderController ;
use App\Http\Controllers\ServiceProvider\providerCategoryController;
use App\Http\Controllers\ServiceProvider\ProviderServiceController;
use App\Http\Controllers\ServiceProvider\ServiceProviderCategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
});

// لوحة التحكم العامة (بعد تسجيل الدخول)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// مجموعة Routes للمسؤول (admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // AdminController routes
    Route::get('/dashboard', [AdminController::class, 'adminDashboard'])->name('dashboard');
    Route::get('/logout', [AdminController::class, 'AdminDestroy'])->name('logout');
    Route::get('/profile', [AdminController::class, 'adminProfile'])->name('profile');
    Route::post('/update', [AdminController::class, 'updateProfile'])->name('update');
    Route::get('/change/password', [AdminController::class, 'AdminChangePassword'])->name('change.password');
    Route::post('/update-password', [AdminController::class, 'AdminUpdatePassword'])->name('update.password');

    // Users Routes
    Route::get('users', [AdminController::class, 'admin_users'])->name('users.list');
    Route::get('users/view/{id}', [AdminController::class, 'admin_users_view'])->name('users.view');
    Route::delete('users/{id}/soft-delete', [AdminController::class, 'softDelete'])->name('users.softDelete');
    Route::delete('users/{id}/force-delete', [AdminController::class, 'forceDelete'])->name('users.forceDelete');
    Route::put('users/{id}/restore', [AdminController::class, 'restore'])->name('users.restore');
    Route::get('users/trashed', [AdminController::class, 'trashed'])->name('users.trashed');

    // Categories Routes
    Route::resource('categories', CategoryController::class);
    // Route::get('categories/trashed', [CategoryController::class, 'trashed'])->name('categories.trashed');
    // Route::delete('categories/{id}/soft-delete', [CategoryController::class, 'softDelete'])->name('categories.softDelete');
    // Route::put('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    // Route::delete('categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

    // Services Routes
    Route::resource('services', ServiceController::class);
//     Route::delete('services/{id}/soft-delete', [ServiceController::class,'softDelete'])->name('services.softDelete');
//     Route::put('services/{id}/restore', [ServiceController::class,'restore'])->name('services.restore');
//     Route::delete('services/{id}/force-delete', [ServiceController::class,'forceDelete'])->name('services.forceDelete');
//     Route::get('services/trashed', [ServiceController::class,'trashed'])->name('services.trashed');
});

// صفحة تسجيل دخول المسؤول
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');

// مجموعة Routes لمزود الخدمة
Route::middleware(['auth', 'role:service_provider'])->prefix('provider')->name('provider.')->group(function () {
    Route::get('/dashboard', [Service_ProviderController::class, 'service_providerDashboard'])->name('dashboard');
    Route::get('/profile', [Service_ProviderController::class, 'service_providerProfile'])->name('profile');
    Route::post('/update', [Service_ProviderController::class, 'updateProfile'])->name('update');
    Route::get('/change/password', [Service_ProviderController::class, 'ChangePassword'])->name('change.password');
    Route::post('/update-password', [Service_ProviderController::class, 'UpdatePassword'])->name('update.password');
    Route::get('/logout', [Service_ProviderController::class, 'Service_ProviderDestroy'])->name('logout');
    Route::resource('categories', providerCategoryController::class);
    Route::resource('services', ProviderServiceController::class);
});

// صفحة تسجيل دخول مزود الخدمة
Route::get('/provider/login', [Service_ProviderController::class, 'service_providerlogin'])->name('provider.login');

// مجموعة Routes للملف الشخصي للمستخدم (عام)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
