<?php

namespace App\Http\Requests\Shipment;

use App\Http\Requests\Base\BaseFormRequest;

class UpdateShipmentRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'nullable|numeric',
            "name" => "nullable|string",
            "start_date" => "nullable|date",
            "end_date" => "nullable|date",
            "status" => ['nullable', 'in:active,finished,pending,delivered'],
            "order_count" => "nullable|numeric",
            "product_count" => "nullable|numeric",
            "currency_price" => "nullable|numeric",
            "customer_currency_price"=> "required|numeric",
            "shipping_fees_total_profit" => "nullable|numeric",
            "currency_profit" => "nullable|numeric",
            "total_profit" => "nullable|numeric",
            "total_price" => "nullable|numeric",
        ];
    }
}
