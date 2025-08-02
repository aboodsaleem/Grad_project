<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index(Request $request)
{
    $status = $request->status;

    $query = Booking::with(['customer', 'service']);

    if ($status) {
        $query->where('status', $status);
    }

    $bookings = $query->latest()->paginate(10);

    // عدادات الحالات
    $countPending = Booking::where('status', 'pending')->count();
    $countConfirmed = Booking::where('status', 'confirmed')->count();
    $countCompleted = Booking::where('status', 'completed')->count();
    $countCancelled = Booking::where('status', 'cancelled')->count();
    $countTotal = Booking::count();

    return view('admin.bookings.index', compact(
        'bookings',
        'countPending',
        'countConfirmed',
        'countCompleted',
        'countCancelled',
        'countTotal'
    ));
}


    public function accept($id)
{
    $booking = Booking::findOrFail($id);
    $booking->status = 'confirmed';
    $booking->save();

    $notification = [
        'message' => 'Booking accepted successfully.',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);

}

public function reject($id)
{
    $booking = Booking::findOrFail($id);
    $booking->status = 'cancelled';
    $booking->save();

    $notification = [
        'message' => 'Booking rejected successfully.',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);

}

public function complete($id)
{
    $booking = Booking::findOrFail($id);
    $booking->status = 'completed';
    $booking->save();

     $notification = [
        'message' => 'Booking marked as completed.',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);


}

public function destroy($id)
{
    $booking = Booking::findOrFail($id);
    $booking->delete();

    $notification = [
        'message' => 'Booking deleted successfully.',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);

}


public function deleteMultiple(Request $request)
{
    $ids = $request->input('selected_ids', []);

    if (empty($ids)) {
        return redirect()->back()->with('error', 'No bookings selected.');
    }

    Booking::whereIn('id', $ids)->delete();

    return redirect()->back()->with('success', 'Selected bookings deleted successfully.');
}


}
