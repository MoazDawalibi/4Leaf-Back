<?php

namespace App\Http\Requests\Shipment;

use App\Http\Requests\Base\BaseFormRequest;

class DestroyShipmentRequest extends BaseFormRequest
{
  
    public function rules()
    {
        return [
            // 'id' => 'required|numeric',
        ];
    }
  
}
