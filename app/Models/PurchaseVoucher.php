<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseVoucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'voucher_id',
        'status',
        'voucher_actual_amount',
    ];

    public function getVoucher()
    {
        return $this->belongsTo(GiftVoucher::class,'voucher_id');
    }
}
