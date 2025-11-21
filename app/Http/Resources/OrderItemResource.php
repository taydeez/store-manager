<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "store_front" => $this->storeFront->store_name,
            "order_number" => $this->order_number,
            "book" => $this->book->title,
            "quantity" => $this->quantity,
            "unit_price" => $this->unit_price,
            "sub_total" => $this->sub_total,
            'created_at' => $this->created_at,
        ];
    }
}
