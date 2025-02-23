<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\Base\BaseFormRequest;

class UpdateCategoryRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'nullable|numeric',
            "name"=> "nullable|string",
        ];
    }
}
