<?php

namespace App\Http\Requests;

use App\Http\Requests\Base\BaseFormRequest;
use App\Models\User;
use Illuminate\Validation\Rule;

class AuthRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::exists(User::class) 
            ],
            'password' => 'required|string',
        ];
    }
}
