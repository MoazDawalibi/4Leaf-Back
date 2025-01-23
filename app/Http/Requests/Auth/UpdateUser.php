<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Base\BaseFormRequest;


class UpdateUser extends BaseFormRequest
{
  
    public function rules()
    {
        return [
            'role_type' => 'sometimes|string|max:255',
            // 'email' => 'sometimes|string|email|max:255|unique:users',
            'password' => 'sometimes',
        ];
    }
  
}
