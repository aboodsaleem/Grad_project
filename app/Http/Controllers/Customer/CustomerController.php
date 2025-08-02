<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
     public function customerDashboard(){

        $id = Auth::user()->id;
        $userdata = User::find($id);
        $services = Service::with('serviceProvider')->latest()->get();
        $bookings = Booking::with(['service', 'serviceProvider'])->where('user_id', Auth::id())->latest()->get();
        $latestServices = Service::with('serviceProvider')->latest()->take(3)->get();
        return view('customer.userdashboard' , compact('userdata','services','latestServices','bookings'));
  }

public function customerProfileupdate(Request $request){
    $id = Auth::user()->id;
    $userdata = User::findOrFail($id);

    $save_url = $userdata->photo; // إذا لم يتم رفع صورة جديدة، نستخدم القديمة
}




public function updateProfile(Request $request){


    $id = Auth::user()->id;
    $customer = User::findOrFail($id);

    $save_url = $customer->photo; // إذا لم يتم رفع صورة جديدة، نستخدم القديمة

    // ✅ إذا تم رفع صورة جديدة
    if ($request->hasFile('photo')) {
        $image = $request->file('photo');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

        $uploadPath = public_path('upload/customer_images/');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if ($customer->photo && file_exists(public_path($customer->photo))) {
            unlink(public_path($customer->photo));
        }



          $image->move($uploadPath, $name_gen);

        $save_url = 'upload/customer_images/' . $name_gen;
    }

    // ✅ تحديث البيانات

    $customer->update([

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
    $customer = User::findOrFail($id);

    // التحقق فقط من كلمة المرور الجديدة
    $request->validate([
        'new_password' => 'required|min:8',
    ], [
        'new_password.required' => 'يرجى إدخال كلمة المرور الجديدة.',
        'new_password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
    ]);

    // تحديث كلمة المرور
    $customer->update([
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
    $customer = User::findOrFail($id);

    // التحقق فقط من كلمة المرور الجديدة
$request->validate([
    'email' => 'required|email|unique:users,email',
], [
    'email.required' => 'يرجى إدخال البريد الإلكتروني.',
    'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
    'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل.',
]);


    // تحديث كلمة المرور
    $customer->update([
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
    $customer = User::findOrFail($id);

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
    $customer->update([
        'phone' => $request->phone,
    ]);
        $notification = [
        'message' => 'تم تحديث  بنجاح',
        'alert-type' => 'success'
    ];

    return back()->with($notification);
}

public function customerDestroy(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = [
        'message' =>  'log out success',
        'alert-type' => 'success'
       ];
        return redirect()->route('login')->with($notification);


    }
}
