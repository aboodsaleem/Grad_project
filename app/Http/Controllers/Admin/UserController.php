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
    // عرض قائمة المستخدمين مع بحث وفلاتر
    public function admin_users(Request $request)
    {
        $query = User::withTrashed()->orderBy('id', 'desc');

        $query->when($request->id, function($q) use ($request) {
            $q->where('id', $request->id);
        });

        $query->when($request->username, function($q) use ($request) {
            $q->where('username', 'like', '%' . $request->username . '%');
        });

        $query->when($request->email, function($q) use ($request) {
            $q->where('email', 'like', '%' . $request->email . '%');
        });

        $query->when($request->phone, function($q) use ($request) {
            $q->where('phone', 'like', '%' . $request->phone . '%');
        });

        $query->when($request->role, function($q) use ($request) {
            $q->where('role', $request->role);
        });

        $query->when($request->status, function($q) use ($request) {
            $q->where('status', $request->status);
        });

        $users = $query->paginate(10)->withQueryString();

        // إحصائيات المستخدمين
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

    // عرض بيانات مستخدم مفرد
    public function admin_users_view($id)
    {
        $users = User::findOrFail($id);
        return view('admin.users.view', compact('users'));
    }

    // صفحة إضافة مستخدم جديد
    public function admin_users_add()
    {
        return view('admin.users.add');
    }

    // تخزين مستخدم جديد
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
            'remember_token' => Str::random(50),
        ]);

        Mail::to($user->email)->send(new RegisteredMail($user));

        return redirect()
            ->route('admin.users.list')
            ->with('msg', 'User added successfully')
            ->with('type', 'success');
    }

    // صفحة تعديل مستخدم
    public function admin_users_edit($id)
    {
        $users = User::findOrFail($id);
        return view('admin.users.edit', compact('users'));
    }

    // تحديث بيانات المستخدم
    public function admin_users_update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'role'     => 'required|string',
            'status'   => 'required|string',
        ]);

        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->status = $request->status;

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

    // استرجاع مستخدم محذوف مؤقتًا
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

        if ($user->photo && file_exists(public_path($user->photo))) {
            unlink(public_path($user->photo));
        }

        $user->forceDelete();

        return redirect()->route('admin.users.list')->with('success', 'This user has been permanently deleted.');
    }

    // عرض المستخدمين المحذوفين مؤقتًا (سلة المهملات)
    public function trashed()
    {
        $trashedUsers = User::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10);
        return view('admin.users.trashed', compact('trashedUsers'));
    }
}
