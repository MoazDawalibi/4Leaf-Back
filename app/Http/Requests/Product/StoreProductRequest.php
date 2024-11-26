<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\Base\BaseFormRequest;

class StoreProductRequest extends BaseFormRequest
{

    public function rules(): array
    {
        return [
            "status" => ['nullable', 'in:active,finished,pending,delivered'],
            "customer_id"=> "required|numeric",
            "shipment_id"=> "required|numeric",
            "product_count"=> "nullable|numeric",
            "shipping_fees_total_profit"=> "nullable|numeric",
            "currency_profit"=> "nullable|numeric",
            "total_profit"=> "nullable|numeric",
            "total_price"=> "nullable|numeric",
        ];
    }
}
