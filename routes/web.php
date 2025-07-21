<?php

use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Customer\CustomerBookingController;
use App\Http\Controllers\Customer\CustomerReviewController;
use App\Http\Controllers\Customer\CustomerServiceController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceProvider\ProviderBookingController;
use App\Http\Controllers\ServiceProvider\ProviderReviewController;
use App\Http\Controllers\ServiceProvider\ProviderServiceController;
use App\Http\Controllers\ServiceProvider\Service_ProviderController;
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

    // Users Routes (يديرها هنا في AdminController)
    Route::get('users', [UserController::class, 'admin_users'])->name('users.list');
    Route::get('users/view/{id}', [UserController::class, 'admin_users_view'])->name('users.view');
    Route::get('users/add', [UserController::class, 'admin_users_add'])->name('users.add');
    Route::post('users/add', [UserController::class, 'admin_users_store'])->name('users.store');
    Route::get('users/edit/{id}', [UserController::class, 'admin_users_edit'])->name('users.edit');
    Route::post('users/edit/{id}', [UserController::class, 'admin_users_update'])->name('users.update');
    Route::delete('users/{id}/soft-delete', [UserController::class, 'softDelete'])->name('users.softDelete');
    Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.forceDelete');
    Route::put('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::get('users/trashed', [UserController::class, 'trashed'])->name('users.trashed');

    // Email
        Route::get('email/compose', [EmailController::class, 'email_compose'])->name('email_compose');

    // خدمات الأدمن: رؤية وتعديل وحذف (لا يوجد إنشاء)
    Route::resource('services', AdminServiceController::class);

    // الحجوزات: فقط عرض، حذف، تفصيل
    Route::resource('bookings', AdminBookingController::class)->only(['index', 'show', 'destroy']);
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

    // خدمات مزود الخدمة: كل العمليات CRUD
    Route::resource('services', ProviderServiceController::class);

    // الحجوزات: عرض وتفصيل وتحديث الحالة
    Route::resource('bookings', ProviderBookingController::class)->only(['index', 'show']);
    Route::post('bookings/{id}/status', [ProviderBookingController::class, 'updateStatus'])->name('bookings.updateStatus');

    Route::resource('reviews', ProviderReviewController::class)->only(['index', 'show']);

});

// صفحة تسجيل دخول مزود الخدمة
Route::get('/provider/login', [Service_ProviderController::class, 'service_providerlogin'])->name('provider.login');

// مجموعة Routes للعميل
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    // عرض الخدمات المتاحة للعميل (index و show)
    Route::resource('services', CustomerServiceController::class)->only(['index', 'show']);

    // عرض الحجوزات الخاصة بالعميل وإنشاء حجز جديد
    Route::resource('bookings', CustomerBookingController::class)->except(['edit', 'update', 'destroy']);

    // إلغاء الحجز (وظيفة خاصة)
    Route::post('bookings/{id}/cancel', [CustomerBookingController::class, 'cancel'])->name('bookings.cancel');
        Route::resource('reviews', CustomerReviewController::class)->only(['store']);

});

// ملف المستخدم العام (تعديل/حذف البروفايل)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
