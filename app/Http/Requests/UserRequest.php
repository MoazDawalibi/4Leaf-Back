<?php

namespace App\Http\Requests;

use App\Http\Requests\Base\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:30',
            'email' => 'required|email:uniqe:users',
            'password' => 'required|string|min:8',
        ];
    }
}
