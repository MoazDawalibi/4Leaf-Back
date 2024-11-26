<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends BaseModel
{
    use HasFactory;
    public function shipments()
    {
        return $this->belongsTo(Shipment::class,'shipment_id');
    }
    public function customers()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function product(){
        return $this->belongsToMany(Product::class,'order_products' );
    }
}
