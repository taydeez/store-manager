<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreFrontResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id ?? null,
            'store_name' => $this->store_name,
            'store_address' => $this->store_address,
            'store_country' => $this->store_country,
            'store_city' => $this->store_city,
            'store_phone' => $this->store_phone,
            'store_email' => $this->store_email,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'store_manager_name' => $this->user?->name ?? 'No Manager'
        ];
    }
}
