<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Service_ProviderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:service_provider'])->except(['service_providerlogin']);
    }

    public function service_providerlogin()
    {
        return view('service_provider.login');
    }

    public function service_providerDashboard()
    {
        $serviceProviderId = Auth::id();
        $service_provider  = User::findOrFail($serviceProviderId);

        // خدمات المزوّد
        $services = Service::where('service_provider_id', $serviceProviderId)->get();

        // كل الحجوزات
        $bookings = Booking::with(['customer:id,username', 'service:id,name'])
            ->forProvider($serviceProviderId)
            ->latest()
            ->get();

        // الحجوزات المعلّقة
        $pendingBooking = Booking::with(['customer:id,username', 'service:id,name'])
            ->forProvider($serviceProviderId)
            ->where('status', 'pending')
            ->latest()
            ->get();

        // التقييمات
        $avgRating    = (float) Review::where('service_provider_id', $serviceProviderId)->avg('rating');
        $avgRating    = $avgRating ? round($avgRating, 1) : 0.0;
        $reviewsCount = Review::where('service_provider_id', $serviceProviderId)->count();

        // الحجوزات المكتملة
        $completedCount = Booking::forProvider($serviceProviderId)
            ->where('status', 'completed')
            ->count();

        // آخر 5 تقييمات
        $recentReviews = Review::with(['user:id,username,photo'])
            ->where('service_provider_id', $serviceProviderId)
            ->latest()
            ->limit(5)
            ->get();

        $memberSinceYear = optional($service_provider->created_at)->format('Y');

        /* ================== الكروت الديناميكية ================== */
        $today     = Carbon::today();
        $yesterday = (clone $today)->subDay();

        // 1) Today’s Bookings
        $todayBookings = Booking::forProvider($serviceProviderId)
            ->onDate($today)
            ->count();

        $yesterdayBookings = Booking::forProvider($serviceProviderId)
            ->onDate($yesterday)
            ->count();

        $todayBookingsChange = $this->percentChange($todayBookings, $yesterdayBookings);

        // 2) Overall Rating Δ (فرق عن متوسط الأسبوع السابق)
        $last7Start = (clone $today)->subDays(6);  // آخر 7 أيام (اليوم ضمنها)
        $prev7Start = (clone $today)->subDays(13); // الأسبوع السابق
        $prev7End   = (clone $today)->subDays(7);

        $avgPrev7 = (float) Review::where('service_provider_id', $serviceProviderId)
            ->whereBetween('created_at', [$prev7Start->startOfDay(), $prev7End->endOfDay()])
            ->avg('rating');
        $avgPrev7    = $avgPrev7 ? round($avgPrev7, 2) : 0.0;
        $ratingDelta = round($avgRating - $avgPrev7, 2);

        // 3) New Customers (أول حجز لهم عند هذا المزوّد خلال آخر 7 أيام)
        $firstBookings = Booking::forProvider($serviceProviderId)
            ->select('user_id', DB::raw('MIN(booking_date) as first_date'))
            ->groupBy('user_id')
            ->get();

        $newCustomers = $firstBookings->filter(function ($row) use ($last7Start, $today) {
            $d = Carbon::parse($row->first_date);
            return $d->between($last7Start, $today);
        })->count();

        $prevNewCustomers = $firstBookings->filter(function ($row) use ($prev7Start, $prev7End) {
            $d = Carbon::parse($row->first_date);
            return $d->between($prev7Start, $prev7End);
        })->count();

        $newCustomersChange = $this->percentChange($newCustomers, $prevNewCustomers);

        return view('service_provider.index', compact(
            'service_provider',
            'services',
            'bookings',
            'pendingBooking',
            'avgRating',
            'reviewsCount',
            'completedCount',
            'recentReviews',
            'memberSinceYear',
            // الكروت
            'todayBookings',
            'todayBookingsChange',
            'ratingDelta',
            'newCustomers',
            'newCustomersChange'
        ));
    }

    /** تحديث البروفايل (مع تنظيف رقم الهاتف وتوسيع فالديشن الصورة) */
    public function updateProfile(Request $request, $id = null)
    {
        $service_provider = User::findOrFail(Auth::id());

        // نظّف رقم الهاتف من أي محارف غير رقمية (نخزن النسخة النظيفة)
        $rawPhone   = $request->phone;
        $cleanPhone = $rawPhone ? preg_replace('/\D+/', '', $rawPhone) : null;
        $request->merge(['phone' => $cleanPhone]);

        $request->validate([
            'username'      => 'required|string|min:2|max:100',
            'email'         => 'required|email|unique:users,email,' . $service_provider->id,
            'phone'         => 'nullable|digits_between:8,15|unique:users,phone,' . $service_provider->id,
            'address'       => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'city'          => 'nullable|string|max:100',
            // توسيع الأنواع والحجم (يدعم webp/jfif)
            'photo'         => 'nullable|file|mimetypes:image/jpeg,image/png,image/gif,image/webp,image/svg+xml,image/jfif|max:8192',
        ]);

        $save_url = $service_provider->photo;

        if ($request->hasFile('photo')) {
            $image    = $request->file('photo');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            $uploadPath = public_path('upload/service_provider_images/');
            if (!is_dir($uploadPath)) {
                @mkdir($uploadPath, 0755, true);
            }

            if ($service_provider->photo && file_exists(public_path($service_provider->photo))) {
                @unlink(public_path($service_provider->photo));
            }

            $image->move($uploadPath, $name_gen);
            $save_url = 'upload/service_provider_images/' . $name_gen;
        }

        $service_provider->update([
            'username'      => $request->username,
            'email'         => $request->email,
            'phone'         => $cleanPhone, // نخزن النسخة المنظّفة
            'address'       => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'city'          => $request->city,
            'photo'         => $save_url,
        ]);

        return back()->with([
            'message'    => 'تم تحديث بيانات الحساب بنجاح.',
            'alert-type' => 'success',
        ]);
    }

    /** تحديث كلمة المرور */
    public function UpdatePassword(Request $request, $id = null)
    {
        $request->validate([
            'new_password' => 'required|min:8|confirmed',
        ], [
            'new_password.required'  => 'يرجى إدخال كلمة المرور الجديدة.',
            'new_password.min'       => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
            'new_password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ]);

        $service_provider = User::findOrFail(Auth::id());
        $service_provider->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with([
            'message'    => 'تم تحديث كلمة المرور بنجاح.',
            'alert-type' => 'success',
        ]);
    }

    /** تحديث البريد */
    public function Updateemail(Request $request, $id = null)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ], [
            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'email.email'    => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.unique'   => 'هذا البريد الإلكتروني مستخدم بالفعل.',
        ]);

        $service_provider = User::findOrFail(Auth::id());
        $service_provider->update([
            'email' => $request->email,
        ]);

        return back()->with([
            'message'    => 'تم تحديث البريد الإلكتروني بنجاح.',
            'alert-type' => 'success',
        ]);
    }

    /** تحديث الهاتف */
    public function Updatephone(Request $request, $id = null)
    {
        // ننظّف قبل التحقق أيضًا
        $rawPhone   = $request->phone;
        $cleanPhone = $rawPhone ? preg_replace('/\D+/', '', $rawPhone) : null;
        $request->merge(['phone' => $cleanPhone]);

        $request->validate([
            'phone' => 'required|digits_between:8,15|unique:users,phone,' . Auth::id(),
        ], [
            'phone.required'       => 'يرجى إدخال رقم الهاتف.',
            'phone.digits_between' => 'رقم الهاتف يجب أن يكون بين 8 و15 رقمًا.',
            'phone.unique'         => 'رقم الهاتف مستخدم بالفعل.',
        ]);

        $service_provider = User::findOrFail(Auth::id());
        $service_provider->update([
            'phone' => $cleanPhone,
        ]);

        return back()->with([
            'message'    => 'تم تحديث رقم الهاتف بنجاح.',
            'alert-type' => 'success',
        ]);
    }

    /** تسجيل الخروج */
    public function Service_ProviderDestroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    /* ================== دوال مساعدة ================== */

    /** احسب نسبة التغيّر بشكل آمن */
    private function percentChange($current, $previous): int
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        return (int) round((($current - $previous) / $previous) * 100);
    }
}
