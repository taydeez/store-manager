<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MonthlySalesStatisticsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'labels' => [
                'January','February','March','April','May','June',
                'July','August','September','October','November','December'
            ],
            'data' => $this->resource,
        ];
    }
}
