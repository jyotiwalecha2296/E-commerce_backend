<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftVoucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_amount',
        'expires_at',
        'status',
        'description',
        'image',
    ];
}
