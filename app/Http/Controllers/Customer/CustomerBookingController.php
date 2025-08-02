<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;

class CustomerBookingController extends Controller
{
    // عرض كل حجوزات العميل
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())->latest()->get();
        return view('customer.bookings.index', compact('bookings'));
    }

    // عرض نموذج إنشاء الحجز
    public function create()
    {
        $services = Service::with('serviceProvider')->get();
        return view('customer.bookings.create', compact('services'));
    }

    // حفظ الحجز
  public function store(Request $request)
{
    $request->validate([
        'service_id' => 'required|exists:services,id',
        'service_provider_id' => 'required|exists:users,id',
        'booking_date' => 'required|date',
        'start_time' => 'required',
        'end_time' => 'required|after:start_time',
    ]);

    // تحقق من وقت بداية الحجز (start_time)
    $startTime = Carbon::createFromFormat('H:i', $request->start_time);
    $endTime = Carbon::createFromFormat('H:i', $request->end_time);

    $allowedStart = Carbon::createFromTime(8, 0);  // 08:00
    $allowedEnd = Carbon::createFromTime(20, 0);   // 20:00

    if ($startTime->lt($allowedStart) || $startTime->gte($allowedEnd)) {

        $notification = [
        'message' => 'Booking start time must be between 08:00 AM and 08:00 PM',
        'alert-type' => 'warning'
    ];

    return redirect()->back()->with($notification);


    }

    if ($endTime->gt($allowedEnd) || $endTime->lte($allowedStart)) {

        $notification = [
        'message' => 'Booking end time must be between 08:00 AM and 08:00 PM',
        'alert-type' => 'warning'
    ];

    return redirect()->back()->with($notification);
    }

    Booking::create([
        'user_id' => Auth::id(),
        'service_id' => $request->service_id,
        'service_provider_id' => $request->service_provider_id,
        'booking_date' => $request->booking_date,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'description' => $request->description,
        'status' => 'pending',
    ]);

    $notification = [
        'message' => 'Booking Added successfully',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);
}


    // دالة إلغاء الحجز (خاصة إضافية غير موجودة في resource)
     public function destroy($id)
    {
        $booking = Booking::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $booking->delete();



        $notification = [
        'message' => 'Booking cancelled successfully.',
        'alert-type' => 'success'
    ];

    return redirect(url()->previous())->with($notification);
}

}

