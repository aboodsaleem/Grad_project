<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'username',
        'email',
        'phone',
        'password',
        'photo',
        'role',
        'status',
        'date_of_birth',
        'city',
        'address', // ✅ أُضيفت حتى تُحفَظ من نموذج التعديل
    ];

    protected $hidden = ['password','remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password' => 'hashed',
    ];

    // خدمات هذا المستخدم كمزوّد
    public function services()
    {
        return $this->hasMany(Service::class, 'service_provider_id');
    }

    // حجوزاته كعميل
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    // التقييمات التي كتبها كعميل
    public function reviewsWritten()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    // التقييمات التي استلمها كمزوّد
    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'service_provider_id');
    }

    // alias: $provider->reviews => التقييمات المستلمة
    public function reviews()
    {
        return $this->reviewsReceived();
    }

    // (العميل ➜ مزوّدين مفضّلين)  pivot: favorites (user_id, service_provider_id)
public function favoriteProviders()
{
    return $this->belongsToMany(
        User::class,           // الطرف الثاني (مزودين من جدول users)
        'favorites',           // جدول الربط
        'user_id',             // مفتاح العميل في جدول favorites
        'service_provider_id'  // مفتاح المزود في جدول favorites
    )->withTimestamps();
}

// (المزوّد ⇦ مستخدمون قاموا بتفضيله)  pivot: favorites (user_id, service_provider_id)
public function favoritedByUsers()
{
    return $this->belongsToMany(
        User::class,
        'favorites',
        'service_provider_id', // هذا المستخدم كمزوّد
        'user_id'              // العملاء الذين فضّلوه
    )->withTimestamps();
}
}
