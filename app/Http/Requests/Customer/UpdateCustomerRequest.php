<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\Base\BaseFormRequest;

class UpdateCustomerRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'nullable|numeric',
            "name"=> "nullable|string",
            "account_name"=> "nullable|string",
            "customer_type"=> "nullable|string",
            "phone_number"=> "nullable|numeric",
            "note"=> "nullable|string",
        ];
    }
}
