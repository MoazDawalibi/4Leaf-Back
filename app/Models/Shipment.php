<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends BaseModel
{
    use HasFactory;
    public function shipments()
    {
        return $this->hasMany(Order::class);
    }
}
