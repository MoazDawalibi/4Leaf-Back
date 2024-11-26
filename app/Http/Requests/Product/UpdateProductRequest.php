<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\Base\BaseFormRequest;

class UpdateProductRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'nullable|numeric',
            "status" => ['nullable', 'in:active,finished,pending,delivered'],
            "customer_id"=> "nullable|numeric",
            "shipment_id"=> "nullable|numeric",
            "product_count"=> "nullable|numeric",
            "shipping_fees_total_profit"=> "nullable|numeric",
            "currency_profit"=> "nullable|numeric",
            "total_profit"=> "nullable|numeric",
            "total_price"=> "nullable|numeric",
        ];
    }
}
