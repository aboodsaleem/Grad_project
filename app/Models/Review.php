<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'rating',
        'comment',
        'booking_id',
        'service_provider_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serviceProvider()
{
    return $this->belongsTo(User::class, 'service_provider_id');
}


    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
