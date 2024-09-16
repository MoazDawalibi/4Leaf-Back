<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\Base\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class AddCategoryRequest extends BaseFormRequest
{

    public function rules(): array
    {
        return [
            "name"=> "required|string",
            "parent_id"=> "nullable|integer",
            "image"=> "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
        ];
    }
}
