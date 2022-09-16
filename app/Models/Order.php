<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'user_id',
        'sub_total',
        'final_total',
        'coupon_code',
        'coupon_amount',
        'shipping_charges',
        'shipping_method',
        'payment_method',
        'status',
        'voucher_code',
        'voucher_amount',
    ];
    
    public function getOrderItem()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function getUser()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
