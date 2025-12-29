<?php

namespace App\Http\Resources\API\Inventory\IssueInward;

use App\Http\Resources\API\Unit\UnitResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IssueMaterialResource extends JsonResource
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
            'project_id' => $this->project_id,
            'store_warehouses_id' => $this->store_warehouses_id,
            'name' => $this->name,
            'code' => $this->code,
            'specification' => $this->specification !== null && $this->specification !== "NULL"  ? $this->specification : " ",
            'unitId' => $this->unit_id,
            "units" => new UnitResources($this->units),
            'quantity' => $this->quantity,
            'company_id' => $this->company_id,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'total_stk_qty' => $this->total_stk_qty,
            'inventory' => [
                'id' => $this->inventory?->id ? $this->inventory?->id : $this->inventorys?->id,
                'uuid' => $this->inventory?->uuid ? $this->inventory?->uuid : $this->inventorys?->uuid,
                'projects_id' => $this->inventory?->projects_id ? $this->inventory?->projects_id : $this->inventorys?->projects_id,
                'store_warehouses_id' => $this->inventory?->store_warehouses_id ? $this->inventory?->store_warehouses_id : $this->inventorys?->store_warehouses_id,
                'materials_id' => $this->inventory?->materials_id ? $this->inventory?->materials_id : $this->inventorys?->materials_id,
                'activities_id' => $this->inventory?->activities_id ? $this->inventory?->activities_id : $this->inventorys?->activities_id,
                'user_id' => $this->inventory?->user_id ? $this->inventory?->user_id : $this->inventorys?->user_id,
                'date' => $this->inventory?->date ? $this->inventory?->date : $this->inventorys?->date,
                'type' => $this->inventory?->type ? $this->inventory?->type : $this->inventorys?->type,
                'qty' => $this->inventory?->qty ? $this->inventory?->qty : $this->inventorys?->qty,
                'remarks' => $this->inventory?->remarks ? $this->inventory?->remarks : $this->inventorys?->remarks ?? '',
                'company_id' => $this->inventory?->company_id ? $this->inventory?->company_id : $this->inventorys?->company_id,
                'is_active' => $this->inventory?->is_active ? $this->inventory?->is_active : $this->inventorys?->is_active,
                'created_at' => $this->inventory?->created_at ? $this->inventory?->created_at : $this->inventorys?->created_at,
                'updated_at' => $this->inventory?->updated_at ? $this->inventory?->updated_at : $this->inventorys?->updated_at,
                'assets_id' => $this->inventory?->assets_id ? $this->inventory?->assets_id : $this->inventorys?->assets_id,
                'recipt_qty' => $this->inventory?->recipt_qty ? $this->inventory?->recipt_qty : $this->inventorys?->recipt_qty,
                'reject_qty' => $this->inventory?->reject_qty ? $this->inventory?->reject_qty : $this->inventorys?->reject_qty,
                'total_qty' => $this->inventory?->total_qty ? $this->inventory?->total_qty : $this->inventorys?->total_qty,
                'price' => $this->inventory?->price ? $this->inventory?->price : $this->inventorys?->price,
            ],
        ];
    }
}
