<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingFee extends BaseModel
{
    use HasFactory;

    protected $casts = [
        'is_disabled' => 'boolean',
    ];
}
