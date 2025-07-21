<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $fillable = [
        'title',
        'description',
        'price',
        'image',
        'service_provider_id',

    ];

    public function serviceProvider()
{
    return $this->belongsTo(User::class, 'service_provider_id');
}


    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
