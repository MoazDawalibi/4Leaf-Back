<?php

namespace App\Http\Requests\StaticInfo;

use App\Http\Requests\Base\BaseFormRequest;

class UpdateStaticInfoRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'nullable|numeric',
            "key"=> "nullable|string",
            "value"=> "nullable|string",
        ];
    }
}
