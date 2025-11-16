<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BestSellersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = null;
    public function toArray(Request $request): array
    {
        return [
            'labels' => $this->pluck('book.title')->toArray(),
            'datasets' => [
                [
                    'label' => 'Copies Sold',
                    'data' => $this->pluck('total_sold')->toArray(),
                    'backgroundColor' => [
                            '#A8DADC', // Jan - soft aqua
                            '#457B9D', // Feb - calm steel blue
                            '#BFD7EA', // Mar - pale sky blue
                            '#CDE7BE', // Apr - soft moss green
                            '#F2DDA4', // May - muted sand yellow
                    ]
                ]
            ]
        ];
    }
}
