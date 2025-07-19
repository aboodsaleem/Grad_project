<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\RegisteredMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{

public function admin_users(Request $request)
{
    $query = User::withTrashed()->orderBy('id', 'desc');

    // الفلاتر حسب الطلب
    if ($request->has('role')) {
        $query->where('role', $request->role);
    }

    if ($request->has('status')) {
        $query->where('status', $request->status);
    }

    $users = $query->paginate(10);

    // العدادات لجميع المستخدمين
    $countAdmins = User::where('role', 'admin')->count();
    $countProviders = User::where('role', 'service_provider')->count();
    $countCustomers = User::where('role', 'customer')->count();

    $countActive = User::where('status', 'active')->count();
    $countInactive = User::where('status', 'inactive')->count();

    $countTotal = User::count();

    return view('admin.users.list', compact(
        'users',
        'countAdmins',
        'countProviders',
        'countCustomers',
        'countActive',
        'countInactive',
        'countTotal'
    ));
}




public function admin_users_view($id)
{
    $users = User::findOrFail($id);
    return view('admin.users.view', compact('users'));
}

public function admin_users_add(Request $request) {

    return view('admin.users.add');

}

public function admin_users_store(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
        'phone'    => 'nullable|string|max:20',
        'role'     => 'required|string',
        'status'   => 'required|string',

    ]);

    $user = User::create([
    'username' => $request->username,
    'email'    => $request->email,
    'password' => Hash::make($request->password),
    'phone'    => $request->phone,
    'role'     => $request->role,
    'status'   => $request->status,
    'remember_token' => Str::random(50)


]);

    Mail::to($user->email)->send(new RegisteredMail($user));

    return redirect()
        ->route('admin.users.list')
        ->with('msg', 'User added successfully')
        ->with('type', 'success');
}

public function admin_users_edit($id) {
    $users = User::findOrFail($id);
    return view('admin.users.edit', compact('users'));

}

public function admin_users_update(Request $request , $id) {
    $user = User::findOrFail($id);

    $request->validate([
        'username' => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email,' . $user->id,
        'phone'    => 'nullable|string|max:20',
        'role'     => 'required|string',
        'status'   => 'required|string',
        // لا نتحقق من password هنا
    ]);

    $user->username = $request->username;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->role = $request->role;
    $user->status = $request->status;

    // إذا أرسل المستخدم كلمة مرور جديدة (اختياري)
    if ($request->filled('password')) {
        $request->validate([
            'password' => 'string|min:6'
        ]);
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()
        ->route('admin.users.list')
        ->with('msg', 'User updated successfully')
        ->with('type', 'success');


}


// حذف مؤقت (Soft Delete)
public function softDelete($id)
{
    $user = User::findOrFail($id);
    $user->delete();
    return redirect()->route('admin.users.list')->with('success', 'User temporarily deleted');
}

// استرجاع مستخدم
public function restore($id)
{
    $user = User::withTrashed()->findOrFail($id);
    $user->restore();
    return redirect()->route('admin.users.list')->with('success', 'User restored successfully.');
}

// حذف نهائي (Force Delete)
public function forceDelete($id)
{
    $user = User::withTrashed()->findOrFail($id);

    // حذف الصورة من السيرفر إذا وجدت
    if ($user->photo && file_exists(public_path($user->photo))) {
        unlink(public_path($user->photo));
    }

    $user->forceDelete();
    return redirect()->route('admin.users.list')->with('success', 'This user has been permanently deleted.');
}

public function trashed()
{
    $trashedUsers = User::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10);
    return view('admin.users.trashed', compact('trashedUsers'));
}

}
