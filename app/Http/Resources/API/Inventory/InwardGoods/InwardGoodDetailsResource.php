<?php

namespace App\Http\Resources\API\Inventory\InwardGoods;

use App\Http\Resources\AssetsResource;
use App\Http\Resources\MaterialsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InwardGoodDetailsResource extends JsonResource
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
            'inward_goods_id' => $this->inward_goods_id,
            'materials_id' => new MaterialsResource($this->materials),
            'recipt_qty' => $this->recipt_qty,
            'reject_qty' => $this->reject_qty,
            'remarkes' => $this->remarkes !== null ? $this->remarkes : '',
            'price' => $this->price,
            'po_qty' => $this->po_qty,
            'accept_qty' => $this->accept_qty,
            'type' => $this->type,
            'assets_id' => new AssetsResource($this->assets),
        ];
    }
}
