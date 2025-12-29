<?php

namespace App\Http\Resources\API\Unit;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitResources extends JsonResource
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
            'uuid' => $this->uuid,
            'unit' => $this->unit !== null ? $this->unit : '',
            'unit_coversion' => $this->unit_coversion !== null ? $this->unit_coversion : '',
            'unit_coversion_factor' => $this->unit_coversion_factor !== null ? $this->unit_coversion_factor : '',
        ];
    }
}
