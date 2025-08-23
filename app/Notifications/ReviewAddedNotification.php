<?php

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReviewAddedNotification extends Notification
{
    use Queueable;

    public function __construct(public Review $review) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type'                => 'review_added',
            'message'             => 'A new review has been posted.',
            'review_id'           => $this->review->id,
            'booking_id'          => $this->review->booking_id,
            'service_provider_id' => $this->review->service_provider_id,
            'user_id'             => $this->review->user_id,
            'rating'              => $this->review->rating,
            'comment'             => $this->review->comment,
        ];
    }
}
