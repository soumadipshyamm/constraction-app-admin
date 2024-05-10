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
        $requestMaterialsData = [
            "id" => $this->id,
            "uuid" => $this->uuid,
            "name" => $this->name,
            "class" => $this->class,
            "code" => $this->code,
            "specification" => $this->specification,
            "unit_id" => $this->unit_id,
            "company_id" => $this->company_id,
            "is_active" => $this->is_active,
        ];
        // dd($this->InvInwardGoodDetails);

        if ($this->InvInwardGoodDetails) {
            $history = $this->InvInwardGoodDetails->first(); // Assuming you only want the first history entry
            // dd($history);
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
                ];
            }
        }
        return $requestMaterialsData;
    }
}



// "id" => 2
    //       "uuid" => "4f5ba1f2-8180-417d-a86c-cb7d4aae2a21"
    //       "name" => "aserwe"
    //       "class" => "Class-B"
    //       "code" => "6653bab4dd7f0d"
    //       "specification" => "aaaaaaaaa"
    //       "unit_id" => 1
    //       "company_id" => 1
    //       "is_active" => 1


    // "id" => 3
    // "uuid" => "fbfec4b2-bf30-4cbf-a24c-1b1f9af9e92b"
    // "inward_goods_id" => 1
    // "materials_id" => 2
    // "recipt_qty" => "3"
    // "reject_qty" => 4
    // "remarkes" => "test data next"
    // "company_id" => 1
    // "is_active" => 1
    // "created_at" => "2024-03-28 12:50:32"
    // "updated_at" => "2024-03-28 12:50:32"
    // "deleted_at" => null
    // "accept_qty" => null
    // "po_qty" => null
