<?php

namespace App\Http\Resources\API\Inventory\ReturnGoods;

use App\Http\Resources\API\CompanyUser\UserResource;
use App\Http\Resources\API\Project\ProjectResource;
use App\Http\Resources\API\Store\StoreResources;
use App\Http\Resources\AssetsResource;
use App\Http\Resources\MaterialsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvReturnDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $stockQty = $this->inventorys->total_qty ?? 0;

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'inv_issue_goods_id' => $this->inv_return_goods_id,
            // 'materials_id' => $this->materials_id,
            'issue_qty' => $this->return_qty,
            'stock_qty' => $stockQty ?? $this->stock_qty,
            'remarkes' => $this->remarkes !== null ? $this->remarks : '',
            // 'type' => 'materials',
            'type' => $this->type ?? '',
            'materials_id' => new MaterialsResource($this->materials),
            'assets_id' => new AssetsResource($this->assets),
        ];
    }
}
