<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProviderNotificationController extends Controller
{
    // صفحة (اختيارية) لعرض كل إشعارات المزوّد
    public function index(Request $request)
    {
        $user = $request->user();
        $notifications = $user->notifications()->latest()->paginate(10);
        $unreadCount   = $user->unreadNotifications()->count();

        // اعمل صفحة blade إذا بدك، أو رجّع back()
        return view('service_provider.notifications.index', compact('notifications','unreadCount'));
    }

    // تعليم إشعار معيّن كمقروء
    public function markAsRead(Request $request, string $id)
    {
        $n = $request->user()->notifications()->whereKey($id)->first();
        if ($n && is_null($n->read_at)) {
            $n->markAsRead();
        }
        return back()->with(['message'=>'Marked as read','alert-type'=>'success']);
    }

    // تعليم جميع الإشعارات كمقروءة
    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
        return back()->with(['message'=>'All notifications marked as read','alert-type'=>'success']);
    }
}
