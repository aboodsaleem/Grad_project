<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_date',
        'start_time',
        'end_time',
        'status',
        'description',
        'service_id',
        'user_id',
        'service_provider_id',
    ];

    // علاقة الحجز بالعميل (User)
    public function customer()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    // علاقة الحجز بمزود الخدمة
    public function serviceProvider()
    {
        return $this->belongsTo(User::class, 'service_provider_id');
    }

    // علاقة الحجز بالخدمة المحجوزة
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
