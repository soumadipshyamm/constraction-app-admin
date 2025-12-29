<?php

namespace App\Http\Resources\API\Assets;

use Illuminate\Http\Request;
use App\Http\Resources\API\Store\StoreResources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Project\ProjectResource;
use App\Http\Resources\API\Unit\UnitResources;

class AssetsResources extends JsonResource
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
            // 'project_id' => $this->project->project_name,
            // 'store_warehouses_id' =>  $this->store_warehouses->name,
            'code' => $this->code,
            'assets' => $this->name,
            'unit_id' => new UnitResources($this->units),
            'specification' => $this->specification !== null ? $this->specification : ''
        ];
    }
}
