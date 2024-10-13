<?php

namespace App\Http\Requests\Shipment;

use App\Http\Requests\Base\BaseFormRequest;

class StoreShipmentRequest extends BaseFormRequest
{

    public function rules(): array
    {
        return [
            "name"=> "required|string",
            "start_date"=> "required|date",
            "end_date"=> "required|date",
            "status" => ['nullable', 'in:active,finished,pending,delivered'],
            "currency_price"=> "required|numeric",
            "order_count"=> "nullable|numeric",
            "product_count"=> "nullable|numeric",
            "shipping_fees_total_profit"=> "nullable|numeric",
            "currency_profit"=> "nullable|numeric",
            "total_profit"=> "nullable|numeric",
            "total_price"=> "nullable|numeric",
        ];
    }
}
