<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponCodes extends Model
{
    use HasFactory;

    protected $casts = [
        'end_at' => 'datetime',
        'start_at' => 'datetime',
    ];

    protected $fillable = [
        'code',
        'end_at',
        'start_at',
        'usage_count',
    ];
}
