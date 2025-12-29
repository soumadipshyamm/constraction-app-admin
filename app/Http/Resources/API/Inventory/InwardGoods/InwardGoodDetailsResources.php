<?php

namespace App\Http\Resources\API\Inventory\InwardGoods;

use App\Http\Resources\API\Unit\UnitResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InwardGoodDetailsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        // dd($this->type);
        $requestMaterialsData = [
            "id" => $this->id,
            "uuid" => $this->uuid,
            "name" => $this->name,
            "class" => $this->class,
            "code" => $this->code,
            "specification" => $this->specification !== null && $this->specification !== "NULL" ? $this->specification : '',
            // "unit_id" => $this->unit_id,
            "company_id" => $this->company_id,
            "is_active" => $this->is_active,
            "type" => $request->type ?? '',
            "inward_id" => $this->inward_id ?? '',
            "unit_id" => new UnitResources($this->units),
        ];


        if ($this->InvInwardGoodDetails) {
            $history = $this->InvInwardGoodDetails->where('inward_goods_id', $this->inward_id)->first(); // Assuming you only want the first history entry
            // dd($history);
            if ($history) {
                $requestMaterialsData += [
                    'InvInwardGoodDetails_id' => $history->id,
                    'InvInwardGoodDetails_uuid' => $history->uuid,
                    'inward_goods_id' => $history->inward_goods_id,
                    'materials_id' => $history->materials_id,
                    'recipt_qty' => $history->recipt_qty,
                    'reject_qty' => $history->reject_qty,
                    'price' => $history->price,
                    'remarkes' => $history->remarkes,
                    'InvInwardGoodDetails_company_id' => $history->company_id,
                    'is_active' => $history->is_active,
                    'created_at' => $history->created_at,
                    'accept_qty' => $history->accept_qty,
                    'po_qty' => $history->po_qty,
                ];
            } else {
                $requestMaterialsData += [
                    'InvInwardGoodDetails_id' => '',
                    'InvInwardGoodDetails_uuid' => '',
                    'inward_goods_id' => '',
                    'materials_id' => '',
                    'recipt_qty' => '',
                    'reject_qty' => '',
                    'price' => '',
                    'remarkes' => '',
                    'InvInwardGoodDetails_company_id' => '',
                    'is_active' => '',
                    'created_at' => '',
                    'accept_qty' => '',
                    'po_qty' => '',
                ];
            }
        }
        return $requestMaterialsData;
    }
}
