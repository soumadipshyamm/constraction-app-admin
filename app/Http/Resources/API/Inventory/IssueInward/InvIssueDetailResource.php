<?php

namespace App\Http\Resources\API\Inventory\IssueInward;

use App\Http\Resources\AssetsResource;
use App\Http\Resources\MaterialsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvIssueDetailResource extends JsonResource
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
            'inv_issue_goods_id' => $this->inv_issue_goods_id,
            'materials_id' => $this->materials_id,
            'issue_qty' => $this->issue_qty,
            'stock_qty' => $this->stock_qty,
            'remarkes' => $this->remarkes !== null ? $this->remarkes : '',
            'type' => $this->type,
            'materials_id' => new MaterialsResource($this->materials),
            'assets_id' => new AssetsResource($this->assets),
        ];
    }
}
