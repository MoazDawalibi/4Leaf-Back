<?php

namespace App\Http\Requests\StaticInfo;

use App\Http\Requests\Base\BaseFormRequest;

class StoreStaticInfoRequest extends BaseFormRequest
{

    public function rules(): array
    {
        return [
            "key"=> "required|string",
            "value"=> "required|string",
        ];
    }
}
