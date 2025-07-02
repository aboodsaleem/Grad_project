<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'service_id',
        'user_id',
        'rating',
        'comment'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class)->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault(); // العميل
    }
}
