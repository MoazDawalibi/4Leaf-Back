<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\Base\BaseFormRequest;

class UpdateProductRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'nullable|numeric',
            "order_id"=> "required|numeric",
            "name"=> "nullable|string",
            "shipping_fees"=> "nullable|numeric",
            "discount"=> "nullable|numeric",
            "product_quantity"=> "nullable|numeric",
            // "price_with_currency" => "nullable|numeric", 
            // "price_with_quantity" =>"nullable|numeric",
            "price"=> "nullable|numeric",
            "product_options"=> "nullable",
        ];
    }
}
