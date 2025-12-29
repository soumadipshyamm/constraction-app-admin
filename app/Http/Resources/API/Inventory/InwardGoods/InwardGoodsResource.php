<?php

namespace App\Http\Resources\API\Inventory\InwardGoods;

use App\Http\Resources\API\Vendor\VendorResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InwardGoodsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->invInwardGood);
        $entryType = new InwardEntryTypeResource($this->entryType);
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'inv_inwards_id' => new InwardResource($this->InvInward),
            'grn_no' => $this->grn_no,
            'date' => $this->date,
            'inv_inward_entry_types_id' => $entryType ?? null,
            'delivery_ref_copy_no' => $this->delivery_ref_copy_no,
            'delivery_ref_copy_date' => $this->delivery_ref_copy_date,
            'img' =>  url('/upload/' . $this->img ?? ''),
            'remarkes' => $this->remarkes,
            'vendors_id' => findEntryType($entryType->slug, $this->vendor_id),
            // 'vendors_id' => new VendorResources($this->vendores),
            'InvInwardGoodDetails' => InwardGoodDetailsResource::collection($this->InvInwardGoodDetails),
        ];
    }
}
