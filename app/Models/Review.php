<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
    'booking_id',
    'user_id',
    'service_provider_id',
    'rating',
    'comment',
];

    // علاقة مع العميل
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // علاقة مع مزود الخدمة
    public function serviceProvider()
{
    return $this->belongsTo(User::class, 'service_provider_id');
}


    // علاقة مع الحجز
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
