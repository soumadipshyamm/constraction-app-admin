<?php

namespace App\Http\Resources\API\Inventory\IssueInward;

use App\Http\Resources\ActivitesResource;
use App\Http\Resources\API\Activities\ActiviteiesResources;
use App\Http\Resources\API\Unit\UnitResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvIssuegoodDetailResource extends JsonResource
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
            "specification" => $this->specification !== null && $this->specification !== "NULL" ? $this->specification : '',
            "unit_id" => new UnitResources($this->units),
            "company_id" => $this->company_id,
            "is_active" => $this->is_active,
            "type" =>  $this->type,
            "tag_id" => $this->tag_id ?? '',
            "issue_lists" => $this->tag_id ? issueTagFinder($this->tag_id, $this->inv_issue_lists_id) : '',
            "issue_id" => $this->issue_id ?? '',
            'stock_qty' => $this->stockQty ?? 0,
        ];
        // dd($this);
        // dd($this->invIssuesDetails->toArray());
        // if ($this->whenLoaded('invIssuesDetails') && $this->invIssuesDetails->isNotEmpty()) {
        // Assuming you only want the first history entry
        if ($this->invIssuesDetails) {
            $history = $this->invIssuesDetails->where('inv_issue_goods_id', $this->issue_id)->first();
            if ($history) {
                $requestMaterialsData += [
                    'issue_goods_details_id' => $history->id,
                    'inv_issue_goods_id' => $history->inv_issue_goods_id,
                    'materials_id' => $history->materials_id,
                    'issue_qty' => $history->issue_qty,
                    'stock_qty' => $history->stock_qty,
                    'remarkes' => $history->remarkes !== null && $history->remarkes !== "NULL" ? $history->remarkes : '',
                    'type' => $history->type,
                    'assets_id' => $history->assets_id,
                    'activities_id' => new ActiviteiesResources($history->activites)
                ];
            } else {
                $requestMaterialsData += [
                    'issue_goods_details_id' => '',
                    'inv_issue_goods_id' => '',
                    'activities_id' => '',
                    'issue_qty' => '',
                    'stock_qty' => '',
                    'remarkes' => '',
                    'type' => '',
                    'assets_id' => ''
                ];
            }
        }


        return $requestMaterialsData;
    }
}


 // }
        // if ($this->invIssuesDetails) {
        //     $history = $this->invIssuesDetails->map(function ($detail) {
        //         return [
        //             'id' => $detail->id,
        //             'uuid' => $detail->uuid,
        //             'inv_issue_goods_id' => $detail->inv_issue_goods_id,
        //             'materials_id' => $detail->materials_id,
        //             'activities_id' => $detail->activities_id,
        //             'issue_qty' => $detail->issue_qty,
        //             'stock_qty' => $detail->stock_qty,
        //             'remarkes' => $detail->remarkes,
        //             'type' => $detail->type,
        //             'company_id' => $detail->company_id,
        //             'is_active' => $detail->is_active,
        //             'created_at' => $detail->created_at,
        //             'updated_at' => $detail->updated_at,
        //             'deleted_at' => $detail->deleted_at,
        //             'assets_id' => $detail->assets_id
        //         ];
        //     });
        //     $requestMaterialsData['invIssuesDetails'] = $history;
        // }



// {
    //     $requestMaterialsData = [
    //         "id" => $this->id,
    //         "uuid" => $this->uuid,
    //         "name" => $this->name,
    //         "class" => $this->class,
    //         "code" => $this->code,
    //         "specification" => $this->specification,
    //         "unit_id" => new UnitResources($this->units),
    //         "company_id" => $this->company_id,
    //         "is_active" => $this->is_active,
    //         "entry_type" => $this->type ?? '',
    //         "issue_id" => $this->issue_id ?? ''
    //     ];

    //     if ($this->invIssuesDetails) {
    //         $filteredDetails = $this->invIssuesDetails->filter(function ($detail) {
    //             return $detail->inv_issue_goods_id == $this->issue_id;
    //         })->values();
    //         // $requestMaterialsData = [];
    //         $requestMaterialsData['invIssuesDetails'] = $filteredDetails->map(function ($detail) {
    //             return [
    //                 'id' => $detail->id,
    //                 'uuid' => $detail->uuid,
    //                 'inv_issue_goods_id' => $detail->inv_issue_goods_id,
    //                 'materials_id' => $detail->materials_id,
    //                 'activities_id' => $detail->activities_id,
    //                 'issue_qty' => $detail->issue_qty,
    //                 'stock_qty' => $detail->stock_qty,
    //                 'remarkes' => $detail->remarkes,
    //                 'type' => $detail->type,
    //                 'company_id' => $detail->company_id,
    //                 'is_active' => $detail->is_active,
    //                 'created_at' => $detail->created_at,
    //                 'updated_at' => $detail->updated_at,
    //                 'deleted_at' => $detail->deleted_at,
    //                 'assets_id' => $detail->assets_id
    //             ];
    //         });
    //     } else {
    //         $requestMaterialsData['invIssuesDetails'] = [];
    //     }

    //     return $requestMaterialsData;
    // }


    // {
    //     $unitData = $this->units ?new UnitResources($this->units) : null;

    //     // Base material/asset data
    //     $baseData = [
    //         "id" => $this->id,
    //         "uuid" => $this->uuid,
    //         "name" => $this->name,
    //         "class" => $this->class,
    //         "code" => $this->code,
    //         "specification" => $this->specification,
    //         "unit_id" => $unitData,
    //         "company_id" => $this->company_id,
    //         "is_active" => $this->is_active,
    //         "entry_type" => $this->type ?? '',
    //         "issue_id" => $this->issue_id ?? ''
    //     ];

    //     // If there are issue details, we need to transform them
    //     if ($this->invIssuesDetails && $this->invIssuesDetails->isNotEmpty()) {
    //         $details = $this->invIssuesDetails->map(function ($detail) use ($baseData) {
    //             return array_merge($baseData, [
    //                 'invIssuesDetails_id' => $detail->id,
    //                 'invIssuesDetails_uuid' => $detail->uuid,
    //                 'inv_issue_goods_id' => $detail->inv_issue_goods_id,
    //                 'materials_id' => $detail->materials_id,
    //                 'activities_id' => $detail->activities_id,
    //                 'issue_qty' => $detail->issue_qty,
    //                 'stock_qty' => $detail->stock_qty,
    //                 'remarkes' => $detail->remarkes,
    //                 'type' => $detail->type,
    //                 'company_id' => $detail->company_id,
    //                 'is_active' => $detail->is_active,
    //                 'created_at' => $detail->created_at,
    //                 'updated_at' => $detail->updated_at,
    //                 'deleted_at' => $detail->deleted_at,
    //                 'assets_id' => $detail->assets_id
    //             ]);
    //         })->toArray();

    //         return $details;
    //     } else {
    //         // Return base data if there are no issue details
    //         return [$baseData];
    //     }
    // }


    // {
    //     // dd($this);
    //     $baseData = [
    //         "id" => $this->id,
    //         "uuid" => $this->uuid,
    //         "name" => $this->name,
    //         "class" => $this->class,
    //         "code" => $this->code,
    //         "specification" => $this->specification,
    //         "unit_id" => new UnitResources($this->units),
    //         "company_id" => $this->company_id,
    //         "is_active" => $this->is_active,
    //         "entry_type" => $this->type ?? '',
    //         "issue_id" => $this->issue_id ?? ''
    //     ];

    //     $details = $this->invIssuesDetails->map(function ($detail) use ($baseData) {
    //         return array_merge($baseData, [
    //             "invIssuesDetails_id" => $detail->id,
    //             "invIssuesDetails_uuid" => $detail->uuid,
    //             "inv_issue_goods_id" => $detail->inv_issue_goods_id,
    //             "materials_id" => $detail->materials_id,
    //             "activities_id" => $detail->activities_id,
    //             "issue_qty" => $detail->issue_qty,
    //             "stock_qty" => $detail->stock_qty,
    //             "remarkes" => $detail->remarkes,
    //             "type" => $detail->type,
    //             "company_id" => $detail->company_id,
    //             "is_active" => $detail->is_active,
    //             "created_at" => $detail->created_at,
    //             "updated_at" => $detail->updated_at,
    //             "deleted_at" => $detail->deleted_at,
    //             "assets_id" => $detail->assets_id
    //         ]);
    //     });

    //     return $details->toArray();
    // }


    // dd($this->invIssuesDetails->toArray());


// "id" => 33
// "uuid" => "c163fd77-7862-4f6a-9bfd-30e4b13b616f"
// "inv_issue_goods_id" => 36
// "materials_id" => 25
// "activities_id" => null
// "issue_qty" => "10"
// "stock_qty" => null
// "remarkes" => null
// "type" => "materials"
// "company_id" => 2
// "is_active" => 1
// "created_at" => "2024-05-29T11:28:46.000000Z"
// "updated_at" => "2024-05-29T11:28:46.000000Z"
// "deleted_at" => null
// "assets_id" => null
