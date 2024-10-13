<?php

namespace App\Services;

use App\Models\Order;
use App\Services\Base\BaseService;

class OrderService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Order::class);
    }
    public function index($shipment_id = null)
    {
        return Order::with('shipments')
        ->with(relations: 'users')
        ->when($shipment_id , function($q) use ($shipment_id) {
            $q->whereShipmentId($shipment_id);
        })->get();
    }
    public function indexWithFilter(
        $per_page = 8,
        $page = 1,
        $search = null,
        $user_id = null, 
        $status = null)
    {
        $data = Order::with('shipments')
        ->when($user_id, function ($q) use ($user_id) {
            return $q->whereStartDate( $user_id);
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
