<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'service_provider_id',
        'user_id',
        'booking_date',
        'start_time',
        'end_time',
        'description',
        'status',
    ];

    /* ================= علاقات ================ */
    public function customer()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function serviceProvider()
    {
        return $this->belongsTo(\App\Models\User::class, 'service_provider_id');
    }

    public function service()
    {
        return $this->belongsTo(\App\Models\Service::class);
    }

    public function review()
    {
        return $this->hasOne(\App\Models\Review::class, 'booking_id');
    }

    /* ============ Accessors ============ */
    public function getStartTimeFormattedAttribute(): ?string
    {
        if (!$this->start_time) return null;
        try { return \Carbon\Carbon::createFromFormat('H:i:s', $this->start_time)->format('g:i A'); }
        catch (\Throwable $e) {
            try { return \Carbon\Carbon::createFromFormat('H:i', $this->start_time)->format('g:i A'); }
            catch (\Throwable $e2) { return (string) $this->start_time; }
        }
    }

    public function getEndTimeFormattedAttribute(): ?string
    {
        if (!$this->end_time) return null;
        try { return \Carbon\Carbon::createFromFormat('H:i:s', $this->end_time)->format('g:i A'); }
        catch (\Throwable $e) {
            try { return \Carbon\Carbon::createFromFormat('H:i', $this->end_time)->format('g:i A'); }
            catch (\Throwable $e2) { return (string) $this->end_time; }
        }
    }

    /* ============ Casts ============ */
    protected $casts = [
        'booking_date' => 'date',
    ];

    /* ============ Scopes نستخدمها في الإحصائيات ============ */

    // فلترة بالمزوّد
    public function scopeForProvider($q, $providerId)
    {
        return $q->where('service_provider_id', $providerId);
    }

    // حجوزات يوم محدد (افتراضي: اليوم)
    public function scopeOnDate($q, Carbon $date = null)
    {
        $date = $date ?: Carbon::today();
        return $q->whereDate('booking_date', $date->toDateString());
    }

    // بين تاريخين
    public function scopeBetweenDates($q, Carbon $start, Carbon $end)
    {
        return $q->whereDate('booking_date', '>=', $start->toDateString())
                 ->whereDate('booking_date', '<=', $end->toDateString());
    }
}
