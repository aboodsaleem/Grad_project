<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerNotificationController extends Controller
{
    // صفحة الإشعارات (لو بدكها تبويب داخل الداشبورد)
    public function index(Request $request)
    {
        // لو عندك صفحة مستقلة للإشعارات رجّع فيوها هنا
        // وإلا: حوّل للداشبورد مع الهاش لفتح تبويب الإشعارات
        return redirect()->to(route('customer.dashboard') . '#notifications');
    }

    // تحديد إشعار واحد كمقروء
    public function markAsRead(Request $request, string $id)
    {
        $user = $request->user();
        abort_if(!$user, 403);

        $notification = $user->notifications()->where('id', $id)->firstOrFail();

        if (is_null($notification->read_at)) {
            // طريقتان صح: إمّا markAsRead() أو update(['read_at'=>now()])
            $notification->markAsRead();
        }

        return back()->with([
            'message'    => 'Notification marked as read.',
            'alert-type' => 'success',
        ]);
    }

    // تحديد كل الإشعارات غير المقروءة كمقروءة
    public function markAllAsRead(Request $request)
    {
        $user = $request->user();
        abort_if(!$user, 403);

        $user->unreadNotifications()->update(['read_at' => now()]);

        return back()->with([
            'message'    => 'All notifications marked as read.',
            'alert-type' => 'success',
        ]);
    }
}
