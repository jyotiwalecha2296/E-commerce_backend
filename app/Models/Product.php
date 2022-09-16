<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function getFeaturedProduct($q){

    }

    public function getCollection()
    {
        return $this->belongsTo(Collection::class,'collection_id');
    }
}
