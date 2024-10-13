<?php

namespace App\Http\Requests\ShippingFee;

use App\Http\Requests\Base\BaseFormRequest;

class StoreShippingFeeRequest extends BaseFormRequest
{

    public function rules(): array
    {
        return [
            "name"=> "required|string",
            "image"=> "required|image",
            "price"=> "required|string",
        ];
    }
}
