<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(public Booking $booking) {}

    public function via($notifiable)
    {
        return ['database']; // ممكن تضيف 'broadcast' لاحقًا
    }

    public function toDatabase($notifiable)
    {
        return [
            'type'         => 'booking_created',
            'message'      => 'New booking request received.',
            'booking_id'   => $this->booking->id,
            'service_id'   => $this->booking->service_id,
            'customer_id'  => $this->booking->user_id,
            'provider_id'  => $this->booking->service_provider_id,
            'date'         => $this->booking->booking_date,
            'start_time'   => $this->booking->start_time,
            'end_time'     => $this->booking->end_time,
        ];
    }
}
