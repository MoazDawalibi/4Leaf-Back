<?php

namespace App\Services;

use App\Models\Shipment;
use App\Services\Base\BaseService;

class ShipmentService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Shipment::class);
    }
    public function indexWithFilter(
        $per_page = 8,
        $page = 1,
        $search = null,
        $start_date = null, 
        $end_date = null,
        $currency_price = null,
        $status = null,
        $order_id = null)
    {
        $data = Shipment::when($start_date, function ($q) use ($start_date) {
            return $q->whereStartDate( $start_date);
        })
        ->when($end_date, function ($q) use ($end_date) {
            return $q->whereEndDate($end_date); 
        })
        ->when($currency_price, function ($q) use ($currency_price) {
            return $q->whereCurrencyPrice($currency_price); 
        })
        ->when($status, function ($q) use ($status) {
            return $q->whereStatus($status); 
        });
    
        if ($search) {
            $data->where($this->columnSearch, 'LIKE', '%' . $search . '%');
        }
    
        $shipment = $data->paginate($per_page, ['*'], 'page', $page);
        
        return $shipment;
    }
    
}
