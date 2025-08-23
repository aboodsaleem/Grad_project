<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use App\Models\User; // ⬅️ مضاف: لجلب مزوّد الخدمة وإشعاره
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\ReviewAddedNotification;// ⬅️ مضاف: إشعار تقييم جديد

class CustomerReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * صفحة عرض الحجوزات المكتملة لتقييمها
     */
    public function index()
    {
        $bookings = Booking::with(['service', 'serviceProvider', 'review'])
            ->where('user_id', auth()->id())
            ->where('status', 'completed')
            ->latest('booking_date')
            ->get();

        return view('customer.reviews.index', compact('bookings'));
    }

    /**
     * حفظ تقييم جديد لحجز مكتمل
     */
    public function store(Request $request)
    {
        // Validate
        $data = $request->validate([
            'booking_id'          => ['required', 'integer', 'exists:bookings,id'],
            'service_provider_id' => ['required', 'integer'],
            'rating'              => ['required', 'integer', 'min:1', 'max:5'],
            'comment'             => ['nullable', 'string', 'max:1000'],
        ]);

        // تأكيد أن الحجز للزبون الحالي
        $booking = Booking::with('review')
            ->where('id', $data['booking_id'])
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // لازم يكون مكتمل
        if ($booking->status !== 'completed') {
            return back()->with([
                'message'    => 'You can only rate completed bookings.',
                'alert-type' => 'warning',
            ]);
        }

        // حماية من العبث بالـ hidden provider_id
        if ((int) $data['service_provider_id'] !== (int) $booking->service_provider_id) {
            return back()->with([
                'message'    => 'Invalid provider for this booking.',
                'alert-type' => 'error',
            ]);
        }

        // منع تكرار التقييم لنفس الحجز
        if ($booking->review) {
            return back()->with([
                'message'    => 'You have already reviewed this booking.',
                'alert-type' => 'info',
            ]);
        }

        // إنشاء التقييم
        $review = DB::transaction(function () use ($data, $booking) {
            return Review::create([
                'booking_id'          => $booking->id,
                'user_id'             => auth()->id(),
                'service_provider_id' => $booking->service_provider_id,
                'rating'              => $data['rating'],
                'comment'             => $data['comment'] ?? null,
            ]);
        });

        // ⬇️ جديد: إرسال إشعار لمزوّد الخدمة بأن العميل قام بالتقييم
        $provider = User::find($booking->service_provider_id);
        if ($provider) {
            // لو عندك قناة بريد/داتابيز مفعلة في notification هيشتغل مباشرة
            $provider->notify(new ReviewAddedNotification($review));
        }

        return back()->with([
            'message'    => 'Thanks! Your review has been submitted.',
            'alert-type' => 'success',
        ]);
    }
}
