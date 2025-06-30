<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Availability extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'provider_id',
        'date',
        'start_time',
        'end_time'
    ];

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id'); // مزود الخدمة
    }
}
