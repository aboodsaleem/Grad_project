<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\Admin\GenericAdminNotification;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['service','customer','serviceProvider'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function accept($id)
    {
        $booking = Booking::with('service')->findOrFail($id);
        $booking->status = 'confirmed';
        $booking->save();

        // إشعار الأدمن
        $admins = User::where('role','admin')->get();
        foreach ($admins as $adminUser) {
            $adminUser->notify(new GenericAdminNotification(
                title: 'قبول حجز',
                message: "تم قبول الحجز رقم #{$booking->id} للخدمة ".($booking->service->name ?? '')." بتاريخ {$booking->booking_date} من قِبل ".(auth()->user()->username ?? 'admin')
            ));
        }

        return back()->with(['message'=>'Booking accepted','alert-type'=>'success']);
    }

    public function reject($id)
    {
        $booking = Booking::with('service')->findOrFail($id);
        $booking->status = 'rejected';
        $booking->save();

        // إشعار الأدمن
        $admins = User::where('role','admin')->get();
        foreach ($admins as $adminUser) {
            $adminUser->notify(new GenericAdminNotification(
                title: 'رفض حجز',
                message: "تم رفض الحجز رقم #{$booking->id} للخدمة ".($booking->service->name ?? '')." بتاريخ {$booking->booking_date} من قِبل ".(auth()->user()->username ?? 'admin')
            ));
        }

        return back()->with(['message'=>'Booking rejected','alert-type'=>'info']);
    }

    public function complete($id)
    {
        $booking = Booking::with('service')->findOrFail($id);
        $booking->status = 'completed';
        $booking->save();

        // إشعار الأدمن
        $admins = User::where('role','admin')->get();
        foreach ($admins as $adminUser) {
            $adminUser->notify(new GenericAdminNotification(
                title: 'اكتمال حجز',
                message: "تم تعليم الحجز رقم #{$booking->id} كمكتمل (الخدمة: ".($booking->service->name ?? '').") بتاريخ {$booking->booking_date} بواسطة ".(auth()->user()->username ?? 'admin')
            ));
        }

        return back()->with(['message'=>'Booking completed','alert-type'=>'success']);
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        // إشعار الأدمن (اختياري)
        $admins = User::where('role','admin')->get();
        foreach ($admins as $adminUser) {
            $adminUser->notify(new GenericAdminNotification(
                title: 'حذف حجز',
                message: "تم حذف الحجز رقم #{$id} بواسطة ".(auth()->user()->username ?? 'admin')
            ));
        }

        return back()->with(['message'=>'Booking deleted','alert-type'=>'success']);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            Booking::whereIn('id', $ids)->delete();

            // إشعار الأدمن (اختياري)
            $admins = User::where('role','admin')->get();
            foreach ($admins as $adminUser) {
                $adminUser->notify(new GenericAdminNotification(
                    title: 'حذف حجوزات',
                    message: "تم حذف (".count($ids).") حجوزات دفعة واحدة بواسطة ".(auth()->user()->username ?? 'admin')
                ));
            }
        }
        return back()->with(['message'=>'Selected bookings deleted','alert-type'=>'success']);
    }
}
