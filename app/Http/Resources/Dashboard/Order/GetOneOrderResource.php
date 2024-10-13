<?php

namespace App\Http\Resources\Dashboard\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetOneOrderResource extends JsonResource
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
            'customer_name' => $this->user->name,
            'shipment_id' => $this->shipment->id,
            'status' => $this->status,
            'product_count' => $this->product_count,
            'shipping_fees_total_profit' => $this->shipping_fees_total_profit,
            'currency_profit' => $this->currency_profit,
            'total_profit' => $this->total_profit,
            'total_price' => $this->total_price,
        ];
    }
}
