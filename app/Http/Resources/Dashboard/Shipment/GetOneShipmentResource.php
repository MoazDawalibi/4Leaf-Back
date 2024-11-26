<?php

namespace App\Http\Resources\Dashboard\Shipment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetOneShipmentResource extends JsonResource
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
            'name' => $this->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'currency_price' => $this->currency_price,
            'customer_currency_price' => $this->customer_currency_price,
            'order_count' => $this->order_count,
            'product_count' => $this->product_count,
            'shipping_fees_total_profit' => $this->shipping_fees_total_profit,
            'currency_profit' => $this->currency_profit,
            'total_profit' => $this->total_profit,
            'total_price' => $this->total_price,
        ];
    }
}
