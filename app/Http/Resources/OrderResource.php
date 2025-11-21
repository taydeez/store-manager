<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'status' => $this->status,
            'total_amount' => $this->total_amount,
            'order_number' => $this->order_number,
            'customer' => [
                'id' => $this->customer?->id,
                'name' => $this->customer?->name,
            ],
            'store_front' => [
                'id' => $this->storefront?->id,
                'name' => $this->storefront?->store_name,

            ],
            'order_items' => OrderItemResource::collection($this->items),
            'created_at' => $this->created_at,
        ];
    }
}
