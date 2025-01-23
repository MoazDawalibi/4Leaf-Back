<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends BaseModel
{
    use HasFactory;

    protected $casts = [
        'is_orderd' => 'boolean',
    ];
    public function orders()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function shippingFee()
    {
        return $this->belongsTo(ShippingFee::class, 'shipping_fee_id');
    }
}