<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    // عرض كل الحجوزات
    public function index()
    {
        $bookings = Booking::with(['service', 'customer', 'serviceProvider'])->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    // عرض تفاصيل حجز معين
    public function show($id)
    {
        $booking = Booking::with(['service', 'customer', 'serviceProvider'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    // حذف حجز (مؤقت أو نهائي حسب الحاجة)
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'تم حذف الحجز بنجاح');
    }
}
