<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\Base\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends BaseFormRequest
{

    public function rules(): array
    {
        return [
            
            "name"=> "nullable|string",
            "parent_id"=> "nullable|integer",
            "image"=> "nullable|string",
        ];
    }
}
