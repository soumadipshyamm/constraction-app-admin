<?php

namespace App\Http\Resources\Export;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialsOpeningStockExportResources extends JsonResource
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
            '#' => $this->id??'',
            'name' => $this->name??'',
            'class' => $this->class??'',
            'code' => $this->code??'',
            'unit_id' =>$this->units?->unit??'',
            'specification' => $this->specification??'',
        ];
    }
}
