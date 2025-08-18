<?php

use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Customer\CustomerBookingController;
use App\Http\Controllers\Customer\CustomerReviewController;
use App\Http\Controllers\Customer\CustomerServiceController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\ServiceFavoriteController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\FrontEnd\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceProvider\ProviderBookingController;
use App\Http\Controllers\ServiceProvider\ProviderReviewController;
use App\Http\Controllers\ServiceProvider\ProviderServiceController;
use App\Http\Controllers\ServiceProvider\Service_ProviderController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// الصفحة الرئيسية
Route::get('/', [HomeController::class, 'index'])->name('frontend.home');



// لوحة التحكم العامة (بعد تسجيل الدخول)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// مجموعة Routes للمسؤول (admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // AdminController routes

    Route::controller(AdminController::class)->group(function () {
    Route::get('/dashboard', 'adminDashboard')->name('dashboard');
    Route::get('/logout','AdminDestroy')->name('logout');
    Route::get('/profile', 'adminProfile')->name('profile');
    Route::post('/update',  'updateProfile')->name('update');
    Route::get('/change/password','AdminChangePassword')->name('change.password');
    Route::post('/update-password','AdminUpdatePassword')->name('update.password');
    Route::get('/inactive/provider' , 'Inactiveprovider')->name('inactive.provider');
   Route::get('/active/provider' , 'activeprovider')->name('active.provider');
   Route::get('/inactive/provider/details/{id}',  'InactiveDetails')->name('inactive.details');
   Route::post('/active/provider/{id}',  'ActiveproviderApprove')->name('active.approve');
    Route::get('/active/provider/details/{id}',  'activeDetails')->name('active.details');
   Route::post('/inactive/provider/{id}',  'inActiveproviderApprove')->name('inactive.approve');
        });
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
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/{id}/accept', [AdminBookingController::class, 'accept'])->name('bookings.accept');
    Route::post('/bookings/{id}/reject', [AdminBookingController::class, 'reject'])->name('bookings.reject');
    Route::post('/bookings/{id}/complete', [AdminBookingController::class, 'complete'])->name('bookings.complete');
    Route::delete('/bookings/{id}/delete', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');
    Route::delete('/bookings/delete-multiple', [AdminBookingController::class, 'deleteMultiple'])->name('bookings.deleteMultiple');

 });
Route::get('admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');


// صفحة تسجيل دخول المسؤول

// مجموعة Routes لمزود الخدمة
Route::middleware(['auth', 'role:service_provider'])->prefix('provider')->name('provider.')->group(function () {
    // ربط كنترولر مزود الخدمة
    Route::controller(Service_ProviderController::class)->group(function () {
        Route::get('/dashboard', 'service_providerDashboard')->name('dashboard');
        Route::post('/update/{id}', 'updateProfile')->name('update');
        Route::post('/update-password/{id}', 'UpdatePassword')->name('update.password');
        Route::post('/update-email/{id}', 'Updateemail')->name('update.email');
        Route::post('/update-phone/{id}', 'Updatephone')->name('update.phone');
        Route::get('/logout', 'Service_ProviderDestroy')->name('logout');
    });
    // خدمات مزود الخدمة: كل العمليات CRUD
    Route::resource('services', ProviderServiceController::class);
    Route::get('/bookings', [ProviderBookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/{id}/accept', [ProviderBookingController::class, 'accept'])->name('bookings.accept');
    Route::post('/bookings/{id}/reject', [ProviderBookingController::class, 'reject'])->name('bookings.reject');
    Route::post('/bookings/{id}/complete', [ProviderBookingController::class, 'complete'])->name('bookings.complete');


});
// مجموعة Routes للعميل
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
        Route::controller(CustomerController::class)->group(function () {
            Route::get('/dashboard', 'customerDashboard')->name('dashboard');
            Route::post('/update','customerProfileupdate')->name('update');
            Route::post('/update-password' , 'customerUpdatePassword')->name('update.password');
            Route::post('/update-email' , 'Updateemail')->name('update.email');
            Route::post('/update-phone' , 'Updatephone')->name('update.phone');
            Route::get('/logout',  'customerDestroy')->name('logout');
        });
    // عرض الخدمات المتاحة للعميل (index و show)
Route::resource('bookings', CustomerBookingController::class)->only([
        'index', 'create', 'store','destroy'
    ]);

    Route::post('/add-to-favorite/{service_id}', [ServiceFavoriteController::class, 'AddToFavorite']);
    Route::post('/remove-from-favorite/{service_id}', [ServiceFavoriteController::class, 'RemoveFromFavorite'])->name('remove.favorite');

    // Route إضافي للإلغاء
});

// ملف المستخدم العام (تعديل/حذف البروفايل)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
