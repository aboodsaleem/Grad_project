<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'username',
        'email',
        'password',
        'photo',
        'phone',
        'address',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // الخدمات التي يقدمها مزود الخدمة
    public function services()
    {
        return $this->hasMany(Service::class, 'provider_id');
    }

    // الحجوزات التي قام بها العميل
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    // التقييمات التي قام بها العميل
    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    // المدفوعات التي قام بها المستخدم (عميل)
    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id');
    }

    // التوافر الخاص بمزود الخدمة
    public function availabilities()
    {
        return $this->hasMany(Availability::class, 'provider_id');
    }
}
