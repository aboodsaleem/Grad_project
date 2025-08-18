<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Service_ProviderController extends Controller
{
    public function service_providerlogin(){

        return view('service_provider.login');
    }
    public function service_providerDashboard(){
        $id = Auth::user()->id;
    $service_provider = User::find($id);
        $serviceProviderId = Auth::id();

    // 🔧 جلب الخدمات التابعة للمزود
    $services = Service::where('service_provider_id', $id)->get();
     $bookings = Booking::with(['customer', 'service'])
        ->where('service_provider_id', $serviceProviderId)
        ->latest()
        ->get();

    $pendingBooking = Booking::with(['customer', 'service'])
        ->where('service_provider_id', $serviceProviderId)
        ->where('status', 'pending')  // فقط الحجوزات المعلقة
        ->latest()
        ->get();

 /** =======================
         *  Today's Bookings + %
         * ======================= */
        $todayBookings = Booking::where('service_provider_id', $serviceProviderId)

            ->count();

        $yesterdayBookings = Booking::where('service_provider_id', $serviceProviderId)
            ->count();

        $todayBookingsChange = $yesterdayBookings > 0
            ? round((($todayBookings - $yesterdayBookings) / $yesterdayBookings) * 100, 1)
            : 0;

            
        /** =======================
         *  Monthly Earnings + %
         * ======================= */
        // $monthlyEarnings = Booking::where('service_provider_id', $serviceProviderId)
        //     ->whereMonth('created_at', now()->month)
        //     ->whereYear('created_at', now()->year)
        //     ->sum('price');

        // $lastMonthEarnings = Booking::where('service_provider_id', $serviceProviderId)
        //     ->whereMonth('created_at', now()->subMonth()->month)
        //     ->whereYear('created_at', now()->subMonth()->year)
        //     ->sum('price');

        // $monthlyEarningsChange = $lastMonthEarnings > 0
        //     ? round((($monthlyEarnings - $lastMonthEarnings) / $lastMonthEarnings) * 100, 1)
        //     : 0;

        /** =======================
         *  Overall Rating + Change
         * ======================= */
        // $overallRating = Review::where('service_provider_id', $serviceProviderId)
        //     ->avg('rating');
        // $overallRating = $overallRating ? round($overallRating, 1) : 0;

        // $lastMonthRating = Review::where('service_provider_id', $serviceProviderId)
        //     ->whereMonth('created_at', now()->subMonth()->month)
        //     ->whereYear('created_at', now()->subMonth()->year)
        //     ->avg('rating');
        // $lastMonthRating = $lastMonthRating ? round($lastMonthRating, 1) : 0;

        // $ratingChange = $lastMonthRating > 0
        //     ? round($overallRating - $lastMonthRating, 1)
        //     : 0;

        /** =======================
         *  New Customers + %
         * ======================= */
        $newCustomers = User::whereHas('bookings', function ($query) use ($serviceProviderId) {
                $query->where('service_provider_id', $serviceProviderId)
                      ->whereMonth('created_at', now()->month)
                      ->whereYear('created_at', now()->year);
            })
            ->count();

        $lastMonthNewCustomers = User::whereHas('bookings', function ($query) use ($serviceProviderId) {
                $query->where('service_provider_id', $serviceProviderId)
                      ->whereMonth('created_at', now()->subMonth()->month)
                      ->whereYear('created_at', now()->subMonth()->year);
            })
            ->count();

        $newCustomersChange = $lastMonthNewCustomers > 0
            ? round((($newCustomers - $lastMonthNewCustomers) / $lastMonthNewCustomers) * 100, 1)
            : 0;

    // 📤 إرسال كلا المتغيرين للعرض
    return view('service_provider.index', compact('service_provider', 'services','bookings','pendingBooking', 'todayBookings', 'yesterdayBookings', 'todayBookingsChange', 'newCustomers', 'lastMonthNewCustomers', 'newCustomersChange' ));
    }




public function updateProfile(Request $request){


    $id = Auth::user()->id;
    $service_provider = User::findOrFail($id);

    $save_url = $service_provider->photo; // إذا لم يتم رفع صورة جديدة، نستخدم القديمة

    // ✅ إذا تم رفع صورة جديدة
    if ($request->hasFile('photo')) {
        $image = $request->file('photo');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

        $uploadPath = public_path('upload/service_provider_images/');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if ($service_provider->photo && file_exists(public_path($service_provider->photo))) {
            unlink(public_path($service_provider->photo));
        }



          $image->move($uploadPath, $name_gen);

        $save_url = 'upload/service_provider_images/' . $name_gen;
    }

    // ✅ تحديث البيانات
    $service_provider->update([

        'username' => $request->username,
        'email' => $request->email,
        'phone' =>$request->phone,
        'address' =>$request->address,
        'date_of_birth' =>$request->date_of_birth,
        'city' =>$request->city,
        'photo' => $save_url,

    ]);

    // ✅ إشعار النجاح
    $notification = [
        'message' => 'تم تحديث  بنجاح',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);
}



public function UpdatePassword(Request $request)
{
    $id = Auth::user()->id;
    $service_provider = User::findOrFail($id);

    // التحقق فقط من كلمة المرور الجديدة
    $request->validate([
        'new_password' => 'required|min:8',
    ], [
        'new_password.required' => 'يرجى إدخال كلمة المرور الجديدة.',
        'new_password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
    ]);

    // تحديث كلمة المرور
    $service_provider->update([
        'password' => Hash::make($request->new_password),
    ]);
        $notification = [
        'message' => 'تم تحديث  بنجاح',
        'alert-type' => 'success'
    ];

    return back()->with($notification);
}
public function Updateemail(Request $request)
{
    $id = Auth::user()->id;
    $service_provider = User::findOrFail($id);

    // التحقق فقط من كلمة المرور الجديدة
$request->validate([
    'email' => 'required|email|unique:users,email',
], [
    'email.required' => 'يرجى إدخال البريد الإلكتروني.',
    'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
    'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل.',
]);


    // تحديث كلمة المرور
    $service_provider->update([
        'email' => $request->email,
    ]);
        $notification = [
        'message' => 'تم تحديث  بنجاح',
        'alert-type' => 'success'
    ];

    return back()->with($notification);
}

public function Updatephone(Request $request)
{
    $id = Auth::user()->id;
    $service_provider = User::findOrFail($id);

    // التحقق فقط من كلمة المرور الجديدة
$request->validate([
    'phone' => 'required|numeric|digits_between:8,15|unique:users,phone',
], [
    'phone.required' => 'يرجى إدخال رقم الهاتف.',
    'phone.numeric' => 'يجب أن يحتوي رقم الهاتف على أرقام فقط.',
    'phone.digits_between' => 'رقم الهاتف يجب أن يكون بين 8 و15 رقمًا.',
    'phone.unique' => 'رقم الهاتف مستخدم بالفعل.',
]);


    // تحديث كلمة المرور
    $service_provider->update([
        'phone' => $request->phone,
    ]);
        $notification = [
        'message' => 'تم تحديث  بنجاح',
        'alert-type' => 'success'
    ];

    return back()->with($notification);
}

public function Service_ProviderDestroy(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return redirect()->route('login');
}
}
