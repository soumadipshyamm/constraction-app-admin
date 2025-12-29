<?php

namespace App\Http\Resources\Export;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetesExportResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            '#' => $this->id,
            // 'id' => $this->id,
            // 'uuid' => $this->uuid,
            'assets' => $this->name,
            'code' => $this->code,
            'unit_id' => $this->units?->unit,
            'specification' => $this->specification,
            'qty' => $this->quantity,
        ];
    }
}
