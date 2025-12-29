<?php

namespace App\Http\Resources\API\Inventory\IssueInward;

use App\Http\Resources\API\Materials\MaterialsResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InwardMaterialListResources extends JsonResource
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
            'id' => $this->id,
            'uuid' => $this->uuid,
            'inward_goods_id' => $this->inward_goods_id,
            'materials_id' => $this->materials_id,
            'recipt_qty' => $this->recipt_qty,
            'reject_qty' => $this->reject_qty,
            'remarkes' => $this->remarkes !== null ? $this->remarkes : '',
            'price' => $this->price,
            'po_qty' => $this->po_qty,
            'accept_qty' => $this->accept_qty,
            'type' => $this->type,
            'company_id' => $this->company_id,
            'is_active' => $this->is_active,
            'assets_id' => $this->assets_id,
            'materials' => new MaterialsResources($this->whenLoaded('materials')) // Load the nested 'materials' resource if available
        ];
    }
}
