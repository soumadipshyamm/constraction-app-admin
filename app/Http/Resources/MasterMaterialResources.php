<?php

namespace App\Http\Resources;

use App\Http\Resources\API\Unit\UnitResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterMaterialResources extends JsonResource
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
            'class' => $this->class,
            'code' => $this->code,
            'specification' => ($this->specification !== null && $this->specification !== "NULL") ? $this->specification : '',
            'unit_id' => ($this->unit_id !== null && $this->unit_id !== "NULL") ? $this->unit_id : '',
            'company_id' => $this->company_id,
            'is_active' => $this->is_active,
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type' => $this->type !== null && $this->type !== 'NULL' ? $this->type : '',
            'units' => new UnitResources($this->whenLoaded('units')), // Assuming 'units' is a relationship
        ];
    }
}
