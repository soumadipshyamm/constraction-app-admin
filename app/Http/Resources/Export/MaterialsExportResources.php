<?php

namespace App\Http\Resources\Export;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialsExportResources extends JsonResource
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
            'id' => $this->id??'',
            'uuid' => $this->uuid??'',
            'code' => $this->code??'',
            'name' => $this->name??'',
            'class' => $this->class??'',
            'unit_id' =>$this->units?->unit??'',
            'specification' => $this->specification??'',
        ];
    }
}
