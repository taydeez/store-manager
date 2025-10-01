<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'added_by' => $this->added_by,
            'title' => $this->title,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'tags' => $this->tags,
            'image_url' => $this->image_url,
            'available' => $this->available,
            'latest_stock' => [
                'grand_quantity' => $this->latestStock?->grand_quantity,
                'main_store_quantity' => $this->latestStock?->main_store_quantity,
                'added' => $this->latestStock?->added,
                'removed' => $this->latestStock?->removed,
                'description' => $this->latestStock?->description,
                'last_updated' => $this->latestStock?->updated_at,
            ],
            'created_at' => $this->created_at,
        ];
    }
}
