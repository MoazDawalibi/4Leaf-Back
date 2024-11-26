<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends BaseModel
{
    use HasFactory;

    public function orders()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
}