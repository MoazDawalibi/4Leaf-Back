<?php

namespace App\Http\Resources\Dashboard\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetOneCustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'account_name' => $this->account_name,
            'phone_number' => $this->phone_number,
            'note' => $this->note,
        ];
    }
}
