<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory;
    
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'address',
        'city',
        'pincode',
        'country',
        'country_code',
        'is_default',
    ];

    public function getShipping()
    {
        return $this->belongsTo(Shipping::class,'country_code','country_code');
    }
}
