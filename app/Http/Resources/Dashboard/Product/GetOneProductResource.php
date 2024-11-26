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
            'order_id' => $this->order_id,
            'name' => $this->name,
            'shipping_fees' => $this->shipping_fees,
            'discount' => $this->discount,
            'product_quantity' => $this->product_quantity,
            'price' => $this->price,
            'price_with_currency' => $this->price_with_currency,
            'price_with_quantity' => $this->price_with_quantity,
            'product_options' => $this->product_options,
            'order' => [
                'status' => $this->status,
                'customer_id' => $this->customer_id,
                'shipment_id' => $this->shipment_id,
                'product_count' => $this->product_count,
                'shipping_fees_total_profit' => $this->shipping_fees_total_profit,
                'currency_profit' => $this->currency_profit,
                'total_profit' => $this->total_profit,
                'total_price' => $this->total_price,
            ]
        ];
    }
}
