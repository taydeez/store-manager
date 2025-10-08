<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreInventoryResource extends JsonResource
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
            'book_id' => $this->book_id,
            'book_title' => $this->book?->title,
            'store_front_id' => $this->store_front_id,
            'store_front_name' => $this->storefront?->store_name,
            'book_quantity' => $this->book_quantity,
            'stocked_quantity' => $this->stocked_quantity,
            'book_price' => $this->book_price,
            'is_available' => $this->is_available,
            'admin_disabled' => $this->admin_disabled,
            'created_at' => $this->created_at,
        ];
    }
}
