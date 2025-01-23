<?php

namespace App\Http\Requests\ShippingFee;

use App\Http\Requests\Base\BaseFormRequest;

class UpdateShippingFeeRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'nullable|numeric',
            "name"=> "nullable|string",
            "image"=> "nullable|image",
            "price"=> "nullable|numeric",
            "is_disabled"=> "required|boolean",
        ];
    }
}
