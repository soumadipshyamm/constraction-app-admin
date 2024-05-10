<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LaboursResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            '#'=> random_int(1,5000),
            'name'=>$this->name,
            'category'=>$this->category,
            'unit_id'=>$this->units?->unit,
        ];
    }
}