<?php

namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:customer'])->except(['customerlogin']);
    }

    public function customerDashboard()
    {
        $customerId = Auth::id();
        $userdata   = Auth::user();

        // الخدمات + مزوّد الخدمة ومتوسط التقييم (على مستوى المزوّد)
        $services = Service::with([
            'serviceProvider' => function ($q) {
                // إن كانت علاقة التقييم بالمزوّد اسمها reviewsReceived غيّر reviews -> reviewsReceived
                $q->withAvg('reviews', 'rating'); // => reviews_avg_rating
            }
        ])->latest()->get();

        // أحدث الخدمات
        $latestServices = Service::with([
            'serviceProvider' => function ($q) {
                $q->withAvg('reviews', 'rating');
            }
        ])->latest()->take(3)->get();

        // حجوزات هذا العميل
        $bookings = Booking::with(['service', 'serviceProvider'])
            ->where('user_id', $customerId)
            ->latest()
            ->get();

        // آخر 3 حجوزات
        $recentBookings = Booking::with(['service', 'serviceProvider', 'review'])
            ->where('user_id', $customerId)
            ->latest()
            ->take(3)
            ->get();

        // IDs المزوّدين المفضّلين (لتلوين القلب على الكروت)
        $favoriteProviderIds = auth()->user()
            ->favoriteProviders()
            ->pluck('users.id')
            ->toArray();

        $favoriteIds = $favoriteProviderIds;

        // الإشعارات
        $notifications = $userdata->notifications()->latest()->get();
        $unreadCount   = $userdata->unreadNotifications()->count();

        return view('customer.userdashboard', compact(
            'userdata',
            'services',
            'latestServices',
            'bookings',
            'recentBookings',
            'notifications',
            'unreadCount',
            'favoriteProviderIds',
            'favoriteIds'
        ));
    }

    public function customerlogin()
    {
        return view('auth.login');
    }

    public function customerProfileupdate(Request $request)
    {
        $userdata = User::findOrFail(Auth::id());

        $request->validate([
            'username'      => 'required|string|min:2|max:100',
            'email'         => ['required','email', Rule::unique('users','email')->ignore($userdata->id)],
            'phone'         => [
                'nullable','string',
                'regex:/^\+?[0-9\s\-\(\)]{8,20}$/',
                Rule::unique('users','phone')->ignore($userdata->id),
            ],
            'address'       => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'city'          => 'nullable|string|max:100',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $save_url = $userdata->photo;

        // رفع صورة جديدة + حذف القديمة إن وُجدت
        if ($request->hasFile('photo')) {
            $image    = $request->file('photo');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            $uploadPath = public_path('upload/customer_images/');
            if (!is_dir($uploadPath)) {
                @mkdir($uploadPath, 0755, true);
            }

            if (!empty($userdata->photo) && is_file(public_path($userdata->photo))) {
                @unlink(public_path($userdata->photo));
            }

            $image->move($uploadPath, $name_gen);
            $save_url = 'upload/customer_images/' . $name_gen;
        }

        $userdata->update([
            'username'      => $request->username,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'city'          => $request->city,
            'photo'         => $save_url,
        ]);

        // ✅ ارجاع للوحة مع فتح تبويب البروفايل مباشرة
        return redirect()
            ->route('customer.dashboard')
            ->withFragment('profile')
            ->with([
                'message'    => 'تم تحديث البيانات بنجاح',
                'alert-type' => 'success',
            ]);
    }

    public function customerUpdatePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:8',
        ], [
            'new_password.required'  => 'يرجى إدخال كلمة المرور الجديدة.',
            'new_password.min'       => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
        ]);

        $userdata = User::findOrFail(Auth::id());
        $userdata->update([
            'password' => Hash::make($request->new_password),
        ]);

        // ✅ افتح تبويب الإعدادات بعد التحديث
        return redirect()
            ->route('customer.dashboard')
            ->withFragment('settings')
            ->with([
                'message'    => 'تم تحديث كلمة المرور بنجاح',
                'alert-type' => 'success',
            ]);
    }

    public function Updateemail(Request $request)
    {
        $userdata = User::findOrFail(Auth::id());

        $request->validate([
            'email' => ['required','email', Rule::unique('users','email')->ignore($userdata->id)],
        ], [
            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'email.email'    => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.unique'   => 'هذا البريد الإلكتروني مستخدم بالفعل.',
        ]);

        $userdata->update([
            'email' => $request->email,
        ]);

        // ✅ ارجاع للبروفايل (أو settings حسب رغبتك)
        return redirect()
            ->route('customer.dashboard')
            ->withFragment('profile')
            ->with([
                'message'    => 'تم تحديث البريد الإلكتروني بنجاح',
                'alert-type' => 'success',
            ]);
    }

    public function Updatephone(Request $request)
    {
        $userdata = User::findOrFail(Auth::id());

        $request->validate([
            'phone' => [
                'required','string',
                'regex:/^\+?[0-9\s\-\(\)]{8,20}$/',
                Rule::unique('users','phone')->ignore($userdata->id),
            ],
        ], [
            'phone.required' => 'يرجى إدخال رقم الهاتف.',
            'phone.string'   => 'يجب أن يكون رقم الهاتف نصًا.',
            'phone.regex'    => 'صيغة رقم الهاتف غير صحيحة.',
            'phone.unique'   => 'رقم الهاتف مستخدم بالفعل.',
        ]);

        $userdata->update([
            'phone' => $request->phone,
        ]);

        // ✅ ارجاع للبروفايل
        return redirect()
            ->route('customer.dashboard')
            ->withFragment('profile')
            ->with([
                'message'    => 'تم تحديث رقم الهاتف بنجاح',
                'alert-type' => 'success',
            ]);
    }

    /** ===================== Favorites (متوافقة مع سكريبت الواجهة) ===================== */

    // GET: customer.favorites.list  -> تُستخدم لملء تبويب Favorites
    public function favoritesList()
    {
        $user = Auth::user();

        $favorites = $user->favoriteProviders()
            ->withAvg('reviews', 'rating')
            ->get()
            ->map(function ($p) {
                return [
                    'id'   => $p->id,
                    'name' => $p->username ?? $p->name,
                    'avg'  => round(($p->reviews_avg_rating ?? 0), 1),
                    'city' => $p->city,
                    'photo'=> asset($p->photo ?: 'upload/no_image.jpg'),
                ];
            })
            ->values();

        return response()->json(['favorites' => $favorites]);
    }

    // POST: customer.favorites.toggle/{id}  -> تُستخدم عند الضغط على زر القلب
    public function favoritesToggle($providerId)
    {
        $user = Auth::user();

        // تأكد أن الـ id يخص مزود خدمة فعلاً (اختياري)
        $provider = User::where('id', $providerId)
            ->whereIn('role', ['service_provider','provider'])
            ->firstOrFail();

        $exists = $user->favoriteProviders()->where('users.id', $providerId)->exists();

        if ($exists) {
            $user->favoriteProviders()->detach($providerId);
            $favorited = false;
        } else {
            $user->favoriteProviders()->attach($providerId);
            $favorited = true;
        }

        return response()->json(['favorited' => $favorited]);
    }

    /** ============================================================================= */

    public function customerDestroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with([
            'message'    => 'Log out success',
            'alert-type' => 'success',
        ]);
    }
}
