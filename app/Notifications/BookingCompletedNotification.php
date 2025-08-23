<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingCompletedNotification extends Notification
{
    use Queueable;

    public function __construct(public Booking $booking) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type'         => 'booking_completed',
            'message'      => 'The provider marked your booking as completed.',
            'booking_id'   => $this->booking->id,
            'service_id'   => $this->booking->service_id,
            'provider_id'  => $this->booking->service_provider_id,
            'date'         => $this->booking->booking_date,
            'start_time'   => $this->booking->start_time,
            'end_time'     => $this->booking->end_time,
        ];
    }
}
