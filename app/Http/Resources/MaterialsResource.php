<?php

namespace App\Http\Resources;

use App\Http\Resources\API\Unit\UnitResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this);

        return [
            // '#' => random_int(1, 5000),
            'id' => $this->id,
            'name' => $this->name,
            'class' => $this->class,
            'code' => $this->code,
            'unit_id' => $this->units ? new UnitResources($this->units) : '',
            'specification' => ($this->specification !== null && $this->specification !== "NULL") ? $this->specification : '',

        ];
    }
}
