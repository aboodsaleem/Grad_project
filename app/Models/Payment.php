<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'method',
        'status',
        'booking_id',
        'user_id',
    ];

    // علاقة الدفع بالحجز
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // المستخدم الذي قام بالدفع (عادة عميل)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
