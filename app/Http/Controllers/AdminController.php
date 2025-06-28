<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
        public function adminDashboard(){

        return view('admin.index');
    }

    public function AdminLogin(){

        return view('admin.admin_login');
    }

    public function AdminProfile(){
        $id = Auth::user()->id;
        $admin = User::find($id);

        return view('admin.admin_profile_view',compact('admin'));
    }

public function updateProfile(Request $request)
{


    $id = Auth::user()->id;
    $admin = User::findOrFail($id);

    $save_url = $admin->photo; // إذا لم يتم رفع صورة جديدة، نستخدم القديمة

    // ✅ إذا تم رفع صورة جديدة
    if ($request->hasFile('photo')) {
        $image = $request->file('photo');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

        $uploadPath = public_path('upload/admin_images/');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if ($admin->photo && file_exists(public_path($admin->photo))) {
            unlink(public_path($admin->photo));
        }



          $image->move($uploadPath, $name_gen);

        $save_url = 'upload/admin_images/' . $name_gen;
    }

    $admin->update([
        'name' => $request->name,
        'username' => $request->username,
        'email' => $request->email,
        'phone' =>$request->phone,
        'address' =>$request->address,
        'photo' => $save_url,
    ]);

    $notification = [
        'message' => 'تم تحديث  بنجاح',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);
}

public function AdminChangePassword() {
    return view('admin.admin_change_password');
}

public function AdminUpdatePassword(Request $request)
{
    $id = Auth::user()->id;
    $admin = User::findOrFail($id);
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

    $admin->update([
        'password' => Hash::make($request->new_password),
    ]);

    return back()->with('status', 'تم تغيير كلمة المرور بنجاح.');
}



public function AdminDestroy(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
}
// End Mehtod

}
