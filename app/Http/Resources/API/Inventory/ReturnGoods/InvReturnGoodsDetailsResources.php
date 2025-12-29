<?php

namespace App\Http\Resources\API\Inventory\ReturnGoods;

use App\Http\Resources\API\Activities\ActiviteiesResources;
use App\Http\Resources\API\Unit\UnitResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class InvReturnGoodsDetailsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $requestMaterialsData = [
            "id" => $this->id,
            "uuid" => $this->uuid,
            "name" => $this->name,
            "class" => $this->class,
            "code" => $this->code,
            "specification" => $this->specification !== null && $this->specification !== 'NULL' ? $this->specification : '',
            "unit_id" => new UnitResources($this->units),
            "company_id" => $this->company_id,
            "is_active" => $this->is_active,
            "type" => $this->type ?? '',
            "tag_id" => $this->tag_id ?? '',
            "issue_lists" => $this->tag_id ? issueTagFinder($this->tag_id, $this->inv_issue_lists_id) : '',
            "return_id" => $this->return_id ?? '',
            'stock_qty' => $this->stockQty ?? 0,
        ];

        // Check if invReturnDetails is loaded and not empty before using it
        if ($this->invReturnDetails && $this->invReturnDetails->isNotEmpty()) {
            $history = $this->invReturnDetails->where('inv_return_goods_id', $this->return_id)->first();

            if ($history) {
                $requestMaterialsData += [
                    'return_goods_details_id' => $history->id,
                    'inv_return_goods_id' => $history->inv_return_goods_id,
                    'materials_id' => $history->materials_id,
                    'recipt_qty' => $history->return_qty,
                    'stock_qty' => $history->stock_qty,
                    'remarkes' => $history->remarkes,
                    'entry_type' => $history->type,
                    'assets_id' => $history->assets_id,
                    'activities_id' => new ActiviteiesResources($history->activites)
                ];
            } else {
                $requestMaterialsData += [
                    'return_goods_details_id' => '',
                    'inv_return_goods_id' => '',
                    'activities_id' => '',
                    'recipt_qty' => '',
                    'stock_qty' => '',
                    'remarkes' => '',
                    'entry_type' => '',
                    'assets_id' => ''
                ];
            }
        } else {
            // Handle the case where invReturnDetails is null or empty
            $requestMaterialsData += [
                'return_goods_details_id' => '',
                'inv_return_goods_id' => '',
                'activities_id' => '',
                'recipt_qty' => '',
                'stock_qty' => '',
                'remarkes' => '',
                'entry_type' => '',
                'assets_id' => ''
            ];
        }

        return $requestMaterialsData;
    }
}
