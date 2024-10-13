<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\Base\BaseFormRequest;

class StoreCustomerRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            "name"=> "required|string",
            "account_name"=> "nullable|string",
            "phone_number"=> "nullable|numeric",
            "note"=> "nullable|string",
        ];
    }
}
