<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderBookingController extends Controller
{
   public function index()
{
    $serviceProviderId = Auth::id();

    // اجلب جميع الحجوزات المرتبطة بالخدمات التي أضافها مزود الخدمة الحالي
    $bookings = Booking::with(['customer', 'service'])
        ->where('service_provider_id', $serviceProviderId)
        ->latest()
        ->get();

    return view('service_provider.bookings.index', compact('bookings'));
}

   public function accept($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->service_provider_id !== auth()->id()) {
            abort(403);
        }

        $booking->status = 'confirmed';
        $booking->save();

         $notification = [
        'message' => 'Booking accepted successfully.',
        'alert-type' => 'success'
    ];

    return redirect()
        ->route('provider.dashboard')
        ->with($notification);

    }

    public function reject($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->service_provider_id !== auth()->id()) {
            abort(403);
        }

        $booking->status = 'cancelled';
        $booking->save();

        $notification = [
        'message' => 'Booking cancelled successfully.',
        'alert-type' => 'success'
    ];

    return redirect()
        ->route('provider.dashboard')
        ->with($notification);

    }

    public function complete($id)
{
    $booking = Booking::findOrFail($id);

    // تحقق إن مزود الخدمة الحالي هو صاحب هذه الخدمة
    if ($booking->service_provider_id != auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    $booking->status = 'completed';
    $booking->save();

    $notification = [
        'message' => 'Booking completed successfully.',
        'alert-type' => 'success'
    ];

    return redirect()
        ->route('provider.dashboard')
        ->with($notification);

}

}
