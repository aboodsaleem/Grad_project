<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderBookingController extends Controller
{
    // عرض الحجوزات الخاصة بمزود الخدمة
    public function index()
    {
        $providerId = Auth::id();
        $bookings = Booking::with(['service', 'customer'])
            ->where('service_provider_id', $providerId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('provider.bookings.index', compact('bookings'));
    }

    // عرض تفاصيل حجز معين
    public function show($id)
    {
        $providerId = Auth::id();
        $booking = Booking::with(['service', 'customer'])
            ->where('service_provider_id', $providerId)
            ->findOrFail($id);

        return view('provider.bookings.show', compact('booking'));
    }

    // تحديث حالة الحجز (قبول، رفض، تحديث الحالة)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected,canceled,completed',
        ]);

        $providerId = Auth::id();
        $booking = Booking::where('service_provider_id', $providerId)->findOrFail($id);

        $booking->status = $request->status;
        $booking->save();

        return redirect()->back()->with('success', 'تم تحديث حالة الحجز');
    }
}
