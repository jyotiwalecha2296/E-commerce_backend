<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendVoucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_id',
        'sender_id',
        'receiver_id',
        'receiver_email',
        'status',
    ];

    public function getVoucher()
    {
        return $this->belongsTo(GiftVoucher::class,'voucher_id');
    }

}
