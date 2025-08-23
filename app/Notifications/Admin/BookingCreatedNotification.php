<?php

namespace App\Notifications\Admin;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(public Booking $booking) {}

    public function via($notifiable) { return ['database']; }

    public function toDatabase($notifiable)
    {
        return [
            'title'   => 'حجز جديد',
            'message' => "تم إنشاء حجز رقم #{$this->booking->id} بواسطة {$this->booking->customer?->username}",
        ];
    }
}
