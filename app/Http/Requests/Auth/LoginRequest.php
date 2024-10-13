<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Base\BaseFormRequest;

class LoginRequest extends BaseFormRequest
{
  
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }
  
}
