<?php

namespace App\Http\Resources;

use App\Http\Resources\API\Project\ProjectResource;
use App\Http\Resources\API\Store\StoreResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OpeningStockResource extends JsonResource
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
            'qty' => $this->qty,
            'material' => new MaterialsResource($this->materials),
            'project' => new ProjectResource($this->projects),
            'store' => new StoreResources($this->stores),
            'opeing_stock_date' => $this->opeing_stock_date,
            'company_id' => $this->company_id,
            'is_active' => $this->is_active,
        ];
    }
}


// return [
//     '#' => random_int(1, 5000),
//     'code' => $this->code,
//     'assets' => $this->assets,
//     'specification' => $this->specification,
//     'unit_id' => $this->units?->unit,
//     'site_usage_unit' => $this->quantity,
// ];

