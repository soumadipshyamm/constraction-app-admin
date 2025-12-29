<?php

namespace App\Http\Resources\Export;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetesOpenStockExportResources extends JsonResource
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
            'project_id' => $this->projects?->project_name,
            'store_id' => $this->stores?->name,
            'assets_id' => $this->assets?->name,
            'assets_code' => $this->assets?->code,
            'units' => $this->assets?->units?->unit,
            'specification' => $this->assets?->specification !== null ? $this->assets?->specification : '',
            'opeing_stock_date' => $this->opeing_stock_date,
            'quantity' => $this->quantity ?? 0,
        ];
    }
}
