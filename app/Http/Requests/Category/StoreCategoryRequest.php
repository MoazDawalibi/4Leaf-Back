<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\Base\BaseFormRequest;

class StoreCategoryRequest extends BaseFormRequest
{

    public function rules(): array
    {
        return [
            "name"=> "required|string",
        ];
    }
}
