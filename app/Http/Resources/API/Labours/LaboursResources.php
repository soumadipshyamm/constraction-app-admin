<?php

namespace App\Http\Resources\API\Labours;

use App\Http\Resources\API\Companies\CompaniesResources;
use App\Http\Resources\API\Unit\UnitResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LaboursResources extends JsonResource
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
            'name' => $this->name,
            'category' => $this->category,
            'unit_id'=>new UnitResources($this->units)
            // 'unit_id' => $this->units?->unit,
            // 'companies' => new CompaniesResources($this->companys),
        ];
    }
}
