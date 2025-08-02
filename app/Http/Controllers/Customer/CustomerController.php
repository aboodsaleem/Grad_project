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

    // ✅ إذا تم رفع صورة جديدة
    if ($request->hasFile('photo')) {
        $image = $request->file('photo');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

        $uploadPath = public_path('upload/user_images/');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if ($userdata->photo && file_exists(public_path($userdata->photo))) {
            unlink(public_path($userdata->photo));
        }



          $image->move($uploadPath, $name_gen);

        $save_url = 'upload/user_images/' . $name_gen;
    }

    // ✅ تحديث البيانات
    $userdata->update([

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
public function userUpdatePassword(Request $request)
{
    $id = Auth::user()->id;
    $vendor = User::findOrFail($id);
    $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|confirmed|min:8|different:old_password',
    ], [
        'old_password.required' => 'يرجى إدخال كلمة المرور القديمة.',
        'new_password.required' => 'يرجى إدخال كلمة المرور الجديدة.',
        'new_password.confirmed' => 'تأكيد كلمة المرور غير مطابق.',
        'new_password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
        'new_password.different' => 'كلمة المرور الجديدة يجب أن تختلف عن القديمة.',
    ]);

    if (!Hash::check($request->old_password, Auth::user()->password)) {
        return back()->with('error', 'كلمة المرور القديمة غير صحيحة.');
    }

    $vendor->update([
        'password' => Hash::make($request->new_password),
    ]);

    return back()->with('status', 'تم تغيير كلمة المرور بنجاح.');
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
