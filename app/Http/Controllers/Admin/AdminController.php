<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\RegisteredMail;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Notifications\Admin\GenericAdminNotification; // ⬅️ للإشعارات العامة للأدمن

class AdminController extends Controller
{
    public function adminDashboard(Request $request)
    {
        $countUsers    = User::count();     // كل المستخدمين (ادمن، مزود، عملاء)
        $countBookings = Booking::count();  // كل الحجوزات
        $countServices = Service::count();  // كل الخدمات

        $bookings = Booking::with(['service', 'customer'])
            ->where('status', 'pending')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.index', compact('countUsers', 'countBookings', 'countServices', 'bookings'));
    }

    public function AdminLogin()
    {
        return view('admin.admin_login');
    }

    public function AdminProfile()
    {
        $id    = Auth::user()->id;
        $admin = User::find($id);

        return view('admin.admin_profile_view', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $id    = Auth::user()->id;
        $admin = User::findOrFail($id);

        $save_url = $admin->photo; // إذا لم يتم رفع صورة جديدة، نستخدم القديمة

        // ✅ إذا تم رفع صورة جديدة
        if ($request->hasFile('photo')) {
            $image    = $request->file('photo');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            $uploadPath = public_path('upload/admin_images/');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            if ($admin->photo && file_exists(public_path($admin->photo))) {
                @unlink(public_path($admin->photo));
            }

            $image->move($uploadPath, $name_gen);
            $save_url = 'upload/admin_images/' . $name_gen;
        }

        $admin->update([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'photo'    => $save_url,
        ]);

        // (لا نرسل إشعارات هنا)

        $notification = [
            'message'    => 'تم تحديث  بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    public function AdminChangePassword()
    {
        return view('admin.admin_change_password');
    }

    public function AdminUpdatePassword(Request $request)
    {
        $id    = Auth::user()->id;
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

        return redirect()
            ->route('admin.profile')
            ->with('msg', 'Change Password successfully')
            ->with('type', 'success');
    }

    public function AdminDestroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    // End Mehtod
    public function Inactiveprovider()
    {
        $inActiveprovider = User::where('status', 'inactive')
            ->where('role', 'service_provider')
            ->latest()
            ->get();

        return view('admin.serviceprovider_setup.inactive', compact('inActiveprovider'));
    }

    public function activeprovider()
    {
        $Activeprovider = User::where('status', 'active')
            ->where('role', 'service_provider')
            ->latest()
            ->get();

        return view('admin.serviceprovider_setup.active', compact('Activeprovider'));
    }
    // End Mehtod

    public function InactiveDetails($id)
    {
        $inactive = User::findOrFail($id);
        return view('admin.serviceprovider_setup.inactive_details', compact('inactive'));
    }

    public function ActiveproviderApprove(Request $request, $id)
    {
        $user = User::findOrFail($id); // جلب المزوّد

        $user->update([
            'status' => 'active' // تحديث الحالة إلى نشط
        ]);

        // ⬅️ إشعار جميع الإدمنز بعملية التفعيل
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new GenericAdminNotification(
                title: 'تفعيل مزود خدمة',
                message: "تم تفعيل {$user->username}"
            ));
        }

        // إشعار للواجهة
        $notification = [
            'message'    => 'Vendor Activated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.active.provider')->with($notification);
    }

    public function activeDetails($id)
    {
        $active = User::findOrFail($id);
        return view('admin.serviceprovider_setup.active_details', compact('active'));
    }

    public function inActiveproviderApprove(Request $request, $id)
    {
        $user = User::findOrFail($id); // جلب المزوّد

        $user->update([
            'status' => 'inactive' // تحديث الحالة إلى غير نشط
        ]);

        // ⬅️ إشعار جميع الإدمنز بعملية التعطيل
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new GenericAdminNotification(
                title: 'تعطيل مزود خدمة',
                message: "تم تعطيل {$user->username}"
            ));
        }

        // إشعار للواجهة
        $notification = [
            'message'    => 'Vendor unActivated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.inactive.provider')->with($notification);
    }

    /* ===================== إشعارات الأدمن ===================== */

    // صفحة/نقطة نهاية الإشعارات (تخدم JSON للـ dropdown أو صفحة مستقلة لاحقاً)
    public function notifications(Request $request)
    {
        $user = $request->user();
        $notifications = $user->notifications()->latest()->limit(20)->get();
        $unreadCount   = $user->unreadNotifications()->count();

        // بإمكانكِ إرجاع فيو بدل JSON لو بدك صفحة كاملة
        // return view('admin.notifications.index', compact('notifications','unreadCount'));

        return response()->json([
            'unread' => $unreadCount,
            'data'   => $notifications->map(function ($n) {
                return [
                    'id'      => $n->id,
                    'title'   => data_get($n->data, 'title', 'Notification'),
                    'message' => data_get($n->data, 'message', ''),
                    'time'    => optional($n->created_at)->diffForHumans(),
                    'read_at' => $n->read_at,
                ];
            }),
        ]);
    }

    // تعليم كل إشعارات الأدمن كمقروءة
    public function markAllAsRead(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }

        return back()->with([
            'message'    => 'All notifications marked as read',
            'alert-type' => 'success',
        ]);
    }

    // تعليم إشعار واحد كمقروء
    public function markAsRead(string $id)
    {
        $user = auth()->user();

        if ($user) {
            $notification = $user->notifications()->where('id', $id)->first();
            if ($notification && is_null($notification->read_at)) {
                $notification->markAsRead();
            }
        }

        return back();
    }
}
