<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingStatusUpdatedNotification extends Notification
{
    use Queueable;

    public function __construct(public $booking, public string $status) {}

    public function via($notifiable)
    {
        return ['database']; // أضف 'mail' إذا أردت
    }

    public function toDatabase($notifiable)
    {
        return [
            'type'       => 'booking_status_updated',
            'booking_id' => $this->booking->id,
            'status'     => $this->status,
            'service'    => optional($this->booking->service)->name,
            'message'    => "Booking status changed to {$this->status}.",
        ];
    }
}
