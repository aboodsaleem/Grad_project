<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontEnd\HomeController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminBookingController;

use App\Http\Controllers\ServiceProvider\Service_ProviderController;
use App\Http\Controllers\ServiceProvider\ProviderServiceController;
use App\Http\Controllers\ServiceProvider\ProviderBookingController;
use App\Http\Controllers\ServiceProvider\ProviderReviewController;
use App\Http\Controllers\ServiceProvider\ProviderNotificationController;

use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\CustomerBookingController;
use App\Http\Controllers\Customer\CustomerReviewController;
use App\Http\Controllers\Customer\CustomerNotificationController;
use App\Http\Controllers\Customer\FavoriteController;

use App\Http\Controllers\EmailController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RedirectIfAuthenticated;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing
Route::get('/', [HomeController::class, 'index'])->name('frontend.home');

// Breeze dashboard example
Route::get('/dashboard', fn () => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Email verification prompt
Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])
    ->middleware('auth')
    ->name('verification.notice');

/* ========================= Admin ========================= */
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::controller(AdminController::class)->group(function () {
        Route::get('/dashboard', 'adminDashboard')->name('dashboard');

        // Profile + auth
        Route::post('/logout', 'AdminDestroy')->name('logout');
        Route::get('/profile', 'adminProfile')->name('profile');
        Route::post('/update',  'updateProfile')->name('update');

        Route::get('/change/password','AdminChangePassword')->name('change.password');
        Route::post('/update-password','AdminUpdatePassword')->name('update.password');

        // Provider approval
        Route::get('/inactive/provider' , 'Inactiveprovider')->name('inactive.provider');
        Route::get('/active/provider'   , 'activeprovider')->name('active.provider');

        Route::get('/inactive/provider/details/{id}',  'InactiveDetails')
            ->whereNumber('id')->name('inactive.details');
        Route::post('/active/provider/{id}',  'ActiveproviderApprove')
            ->whereNumber('id')->name('active.approve');
        Route::get('/active/provider/details/{id}',  'activeDetails')
            ->whereNumber('id')->name('active.details');
        Route::post('/inactive/provider/{id}',  'inActiveproviderApprove')
            ->whereNumber('id')->name('inactive.approve');

        // ✅ Admin notifications (مطلوب لزر "Mark all as read" في الهيدر)
        Route::get('/notifications', 'notifications')->name('notifications.index');
        Route::post('/notifications/{id}/read', 'markAsRead')
            ->whereNumber('id')->name('notifications.read');
        Route::post('/notifications/read-all', 'markAllAsRead')
            ->name('notifications.readAll');
    });

    // Users management
    Route::get('users', [UserController::class, 'admin_users'])->name('users.list');
    Route::get('users/view/{id}', [UserController::class, 'admin_users_view'])->whereNumber('id')->name('users.view');
    Route::get('users/add', [UserController::class, 'admin_users_add'])->name('users.add');
    Route::post('users/add', [UserController::class, 'admin_users_store'])->name('users.store');
    Route::get('users/edit/{id}', [UserController::class, 'admin_users_edit'])->whereNumber('id')->name('users.edit');
    Route::post('users/edit/{id}', [UserController::class, 'admin_users_update'])->whereNumber('id')->name('users.update');
    Route::delete('users/{id}/soft-delete', [UserController::class, 'softDelete'])->whereNumber('id')->name('users.softDelete');
    Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete'])->whereNumber('id')->name('users.forceDelete');
    Route::put('users/{id}/restore', [UserController::class, 'restore'])->whereNumber('id')->name('users.restore');
    Route::get('users/trashed', [UserController::class, 'trashed'])->name('users.trashed');

    // Admin email compose demo
    Route::get('email/compose', [EmailController::class, 'email_compose'])->name('email_compose');

    // Admin services CRUD
    Route::resource('services', AdminServiceController::class);

    // Admin bookings
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/{id}/accept', [AdminBookingController::class, 'accept'])->whereNumber('id')->name('bookings.accept');
    Route::post('/bookings/{id}/reject', [AdminBookingController::class, 'reject'])->whereNumber('id')->name('bookings.reject');
    Route::post('/bookings/{id}/complete', [AdminBookingController::class, 'complete'])->whereNumber('id')->name('bookings.complete');
    Route::delete('/bookings/{id}/delete', [AdminBookingController::class, 'destroy'])->whereNumber('id')->name('bookings.destroy');
    Route::delete('/bookings/delete-multiple', [AdminBookingController::class, 'deleteMultiple'])->name('bookings.deleteMultiple');
});

// Admin login
Route::get('/admin/login',  [AdminController::class , 'AdminLogin'])
    ->name('admin.login')->middleware(RedirectIfAuthenticated::class);

/* ===================== Service Provider ===================== */
Route::middleware(['auth', 'role:service_provider'])
    ->prefix('provider')
    ->name('provider.')
    ->group(function () {

    Route::controller(Service_ProviderController::class)->group(function () {
        Route::get('/dashboard', 'service_providerDashboard')->name('dashboard');

        // Requires {id} كما هو مستخدم في الـ Blade
        Route::post('/update/{id}', 'updateProfile')->whereNumber('id')->name('update');
        Route::post('/update-password/{id}', 'UpdatePassword')->whereNumber('id')->name('update.password');
        Route::post('/update-email/{id}', 'Updateemail')->whereNumber('id')->name('update.email');
        Route::post('/update-phone/{id}', 'Updatephone')->whereNumber('id')->name('update.phone');

        Route::post('/logout', 'Service_ProviderDestroy')->name('logout');
    });

    // Provider services CRUD
    Route::resource('services', ProviderServiceController::class);

    // Provider bookings
    Route::get('/bookings', [ProviderBookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/{id}/accept', [ProviderBookingController::class, 'accept'])->whereNumber('id')->name('bookings.accept');
    Route::post('/bookings/{id}/reject', [ProviderBookingController::class, 'reject'])->whereNumber('id')->name('bookings.reject');
    Route::post('/bookings/{id}/complete', [ProviderBookingController::class, 'complete'])->whereNumber('id')->name('bookings.complete');

    // Provider reviews
    Route::get('/reviews', [ProviderReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/{review}', [ProviderReviewController::class, 'show'])
        ->whereNumber('review')->name('reviews.show');

    // Provider notifications
    Route::get('/notifications', [ProviderNotificationController::class, 'index'])
        ->name('notifications.index');
    Route::post('/notifications/{id}/read', [ProviderNotificationController::class, 'markAsRead'])
        ->name('notifications.read');
    Route::post('/notifications/read-all', [ProviderNotificationController::class, 'markAllAsRead'])
        ->name('notifications.readAll');
});

// Provider login
Route::get('/provider/login', [Service_ProviderController::class, 'service_providerlogin'])
    ->name('provider.login')->middleware(RedirectIfAuthenticated::class);

/* ========================= Customer ========================= */
Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

    Route::controller(CustomerController::class)->group(function () {
        Route::get('/dashboard', 'customerDashboard')->name('dashboard');

        // Profile update (الراوت الرسمي + alias للقديم)
        Route::post('/profile/update','customerProfileupdate')->name('profile.update');
        Route::post('/update','customerProfileupdate')->name('update'); // alias لمناداة route('customer.update')

        Route::post('/update-password' , 'customerUpdatePassword')->name('update.password');
        Route::post('/update-email'    , 'Updateemail')->name('update.email');
        Route::post('/update-phone'    , 'Updatephone')->name('update.phone');

        // Favorites
        Route::post('/favorites/toggle/{provider}', [FavoriteController::class, 'toggle'])
            ->whereNumber('provider')->name('favorites.toggle');
        Route::get('/favorites/list', [FavoriteController::class, 'list'])
            ->name('favorites.list');

        // Logout
        Route::post('/logout',  'customerDestroy')->name('logout');
    });

    // Customer bookings
    Route::resource('bookings', CustomerBookingController::class)
        ->only(['index', 'create', 'store', 'destroy']);

    // Customer reviews
    Route::post('reviews', [CustomerReviewController::class, 'store'])->name('reviews.store');
    Route::get('reviews',  [CustomerReviewController::class, 'index'])->name('reviews.index');

    // Customer notifications
    Route::get('/notifications', [CustomerNotificationController::class, 'index'])
        ->name('notifications.index');
    Route::post('/notifications/{id}/read', [CustomerNotificationController::class, 'markAsRead'])
        ->name('notifications.read');
    Route::post('/notifications/read-all', [CustomerNotificationController::class, 'markAllAsRead'])
        ->name('notifications.readAll');
});

// Customer login
Route::get('/customer/login', [CustomerController::class, 'customerlogin'])
    ->name('customer.login')->middleware(RedirectIfAuthenticated::class);

/* ========================= Profile (Breeze) ========================= */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
