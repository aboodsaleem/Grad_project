<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerBookingController extends Controller
{
    // عرض الخدمات المتاحة ليتم الحجز منها
    public function services()
    {
        $services = Service::where('status', 'approved')->paginate(15);
        return view('customer.services.index', compact('services'));
    }

    // عرض الحجوزات الخاصة بالعميل
    public function index()
    {
        $customerId = Auth::id();
        $bookings = Booking::with(['service', 'serviceProvider'])
            ->where('customer_id', $customerId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('customer.bookings.index', compact('bookings'));
    }

    // عرض نموذج حجز خدمة معينة
    public function create($serviceId)
    {
        $service = Service::findOrFail($serviceId);
        return view('customer.bookings.create', compact('service'));
    }

    // تخزين الحجز
    public function store(Request $request, $serviceId)
    {
        $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string|max:500',
        ]);

        $service = Service::findOrFail($serviceId);

        Booking::create([
            'service_id' => $service->id,
            'customer_id' => Auth::id(),
            'service_provider_id' => $service->service_provider_id,
            'status' => 'pending',
            'booking_date' => $request->booking_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('customer.bookings.index')->with('success', 'تم إنشاء الحجز بنجاح');
    }

    // إلغاء الحجز
    public function cancel($id)
    {
        $customerId = Auth::id();
        $booking = Booking::where('customer_id', $customerId)->findOrFail($id);

        if (in_array($booking->status, ['pending', 'accepted'])) {
            $booking->status = 'canceled';
            $booking->save();

            return redirect()->back()->with('success', 'تم إلغاء الحجز بنجاح');
        }

        return redirect()->back()->with('error', 'لا يمكن إلغاء هذا الحجز');
    }
}
