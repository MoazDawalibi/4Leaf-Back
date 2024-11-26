<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Base\BaseFormRequest;


class UpdateUser extends BaseFormRequest
{
  
    public function rules()
    {
        return [
            'role_type' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ];
    }
  
}
