<?php

namespace App\Http\Resources\Dashboard\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetOneProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'customer_id' => $this->customer_id,
            'shipment_id' => $this->shipment_id,
            'product_count' => $this->product_count,
            'shipping_fees_total_profit' => $this->shipping_fees_total_profit,
            'currency_profit' => $this->currency_profit,
            'total_profit' => $this->total_profit,
            'total_price' => $this->total_price,
            'shipments' => [
                'id' => $this->shipments->id,
                'name' => $this->shipments->name,
                'start_date' => $this->shipments->start_date,
                'end_date' => $this->shipments->end_date,
                'status' => $this->shipments->status,
                'order_count' => $this->shipments->order_count,
                'product_count' => $this->shipments->product_count,
                'currency_price' => $this->shipments->currency_price,
                'shipping_fees_total_profit' => $this->shipments->shipping_fees_total_profit,
                'currency_profit' => $this->shipments->currency_profit,
                'total_profit' => $this->shipments->total_profit,
                'total_price' => $this->shipments->total_price,
            ],
            'customers' => [
                'id' => $this->customers->id,
                'name' => $this->customers->name,
                'account_name' => $this->customers->account_name,
                'phone_number' => $this->customers->phone_number,
                'note' => $this->customers->note,
            ]
        ];
    }
}
