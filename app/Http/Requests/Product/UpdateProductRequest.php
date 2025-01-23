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
            "image"=> "nullable|image",
            "is_ordered"=> "nullable|boolean",
            "price"=> "nullable|numeric",
            "product_options"=> "nullable",
        ];
    }
}
