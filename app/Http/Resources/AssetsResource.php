<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // '#' => random_int(1, 5000),
            // 'project_id' => $this->project->project_name ?? '',
            // 'store_warehouses_id' => $this->store_warehouses->name ?? '',
            'id' => $this->id,
            'uuid' => $this->uuid,
            'code' => $this->code,
            'assets' => $this->name,
            'unit_id' => $this->units?->unit,
            'specification' => $this->specification !== null && $this->specification !== 'NULL' ? $this->specification ?? '' : '',
        ];
    }
}
