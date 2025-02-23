<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\Order;
use App\Models\Shipment;
use App\Services\Base\BaseService;

class OrderService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Order::class);
    }
        public function indexWithFilter(
            $per_page = 8,
            $page = 1,
            $search = null,
            $shipment_id = null, 
            $customer_id = null, 
            $status = null)
        {
            $data = Order::with('shipments')->with('customers')
            ->when($shipment_id, function ($q) use ($shipment_id) {
                return $q->whereShipmentId( $shipment_id);
            })
            ->when($customer_id, function ($q) use ($customer_id) {
                return $q->whereCustomerId( $customer_id);
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


    public function showOrder($id)
    {
        $data = Order::with('shipments')->with('customers')->find($id);

        return $data;
    }
    public function create($data)
    {
        $order = Order::create($data);
    
        $shipment = Shipment::find($order->shipment_id);
    
        if (!$shipment) {
            return ['error' => 'Shipment not found'];
        }
    
        $shipment->update([
            'order_count'=>$shipment->order_count+1  ,
            'updated_at' => now(), 
        ]);
    
        return $order;
    }

    public function delete($id)
    {
        $order = Order::find($id);
        if (!$order){
            throw new CustomException('Resource Not Found',404);
        }
    
        $shipment = Shipment::find($order->shipment_id);
    
        if (!$shipment) {
            return ['error' => 'Shipment not found'];
        }
    
        $shipment->update([
            'order_count'=>$shipment->order_count-1  ,
            'updated_at' => now(), 
        ]);

        $deleted = Order::where("id", $id)->delete();
    }
    
}
