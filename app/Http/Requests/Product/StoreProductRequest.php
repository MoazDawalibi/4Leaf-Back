<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\Base\BaseFormRequest;

class StoreProductRequest extends BaseFormRequest
{

    public function rules(): array
    {
        return [
            "order_id"=> "required|numeric",
            "name"=> "required|string",
            "shipping_fees"=> "required|numeric",
            "discount"=> "nullable|numeric",
            "product_quantity"=> "required|numeric",
            "price"=> "required|numeric",
            // "price_with_currency" => "required|numeric", 
            // "price_with_quantity" =>"required|numeric",
            "product_options"=> "nullable",

        ];
    }
}
