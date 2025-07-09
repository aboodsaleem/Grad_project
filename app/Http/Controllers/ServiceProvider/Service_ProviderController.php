<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Service_ProviderController extends Controller
{
    public function service_providerDashboard(Request $request){

        return view('service_provider.index');
    }
    public function service_providerlogin(){

        return view('service_provider.login');
    }

    public function service_providerProfile(){
        $id = Auth::user()->id;
        $service_provider = User::find($id);

        return view('service_provider.profile_view',compact('service_provider'));
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
        'photo' => $save_url,
    ]);

    // ✅ إشعار النجاح
    $notification = [
        'message' => 'تم تحديث  بنجاح',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);
}

public function ChangePassword() {
    return view('service_provider.change_password');
}

public function UpdatePassword(Request $request)
{
    $id = Auth::user()->id;
    $service_provider = User::findOrFail($id);
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

    $service_provider->update([
        'password' => Hash::make($request->new_password),
    ]);

    return back()->with('status', 'تم تغيير كلمة المرور بنجاح.');
}


    public function Service_ProviderDestroy(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('provider.login');
}
}
