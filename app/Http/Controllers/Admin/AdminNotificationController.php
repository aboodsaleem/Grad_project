<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    public function index(Request $request)
    {
        // احتياط: لو ما في مستخدم (ما لازم يصير لأن الراوت تحت auth:admin)
        $user = $request->user();
        if (!$user) {
            return response()->json(['unread' => 0, 'data' => []], 401);
        }

        // خيار limit للدروبداون (افتراضي 10 – تقدري تزوديها من الكويري سترنج)
        $limit = (int) $request->query('limit', 10);
        if ($limit <= 0) $limit = 10;

        $notifications = $user->notifications()->latest()->take($limit)->get();
        $unreadCount   = $user->unreadNotifications()->count();

        // إن أردتِ صفحة مستقلة:
        // return view('admin.notifications.index', compact('notifications','unreadCount'));

        // أو json للاستهلاك عبر dropdown فقط:
        return response()->json([
            'unread' => $unreadCount,
            'data'   => $notifications->map(function($n){
                return [
                    'id'      => $n->id,
                    'title'   => data_get($n->data,'title','Notification'),
                    'message' => data_get($n->data,'message',''),
                    'time'    => optional($n->created_at)->diffForHumans(),
                    'read_at' => $n->read_at,
                ];
            }),
        ]);
    }

    public function markAsRead(Request $request, string $id)
    {
        $user = $request->user();
        if (!$user) return back();

        $n = $user->notifications()->where('id',$id)->firstOrFail();
        if (is_null($n->read_at)) $n->markAsRead();

        return back()->with(['message'=>'Marked as read','alert-type'=>'success']);
    }

    public function markAllAsRead(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }

        return back()->with(['message'=>'All marked as read','alert-type'=>'success']);
    }
}
