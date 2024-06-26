<?php

namespace App\Http\Resources\API\Inventory\inventor;

use App\Http\Resources\API\Unit\UnitResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryDtailsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        // dd($this);
        $type = $request->goods_type;
        // dd($type);
        $requestMaterialsData = [
            "id" => $this->id,
            "uuid" => $this->uuid,
            "name" => $this->name,
            "class" => $this->class,
            "code" => $this->code,
            "specification" => $this->specification,
            "unit_id" => new UnitResources($this->units),
            "company_id" => $this->company_id,
            "is_active" => $this->is_active,
            "type" => $type ?? '',
            "inward_id" => $this->inward_id ?? ''
        ];
        // dd($this->InvInwardGoodDetails->toArray());

        if ($this->InvInwardGoodDetails) {
            $history = $this->InvInwardGoodDetails->first(); // Assuming you only want the first history entry
            if ($history) {
                $requestMaterialsData += [
                    'InvInwardGoodDetails_id' => $history->id,
                    'InvInwardGoodDetails_uuid' => $history->uuid,
                    'inward_goods_id' => $history->inward_goods_id,
                    'materials_id' => $history->materials_id,
                    'recipt_qty' => $history->recipt_qty,
                    'reject_qty' => $history->reject_qty,
                    'remarkes' => $history->remarkes,
                    'InvInwardGoodDetails_company_id' => $history->company_id,
                    'is_active' => $history->is_active,
                    'created_at' => $history->created_at,
                    'accept_qty' => $history->accept_qty,
                    'po_qty' => $history->po_qty,
                    'price' => $history->price,
                ];
            } else {
                $requestMaterialsData += [
                    'InvInwardGoodDetails_id' => '',
                    'InvInwardGoodDetails_uuid' => '',
                    'inward_goods_id' => '',
                    'materials_id' => '',
                    'recipt_qty' => '',
                    'reject_qty' => '',
                    'remarkes' => '',
                    'InvInwardGoodDetails_company_id' => '',
                    'is_active' => '',
                    'created_at' => '',
                    'accept_qty' => '',
                    'po_qty' => '',
                    'price' => '',
                ];
            }
        }
        return $requestMaterialsData;
    }
}
