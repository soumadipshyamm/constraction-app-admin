<?php

namespace App\Http\Resources\API\Inventory\MaterialRequest;

use App\Http\Resources\API\Activities\ActiviteiesResources;
use App\Http\Resources\API\Inventory\inventor\InventoryResources;
use App\Http\Resources\API\Materials\MaterialsResources;
use App\Http\Resources\API\Project\ProjectResource;
use App\Http\Resources\API\Store\StoreResources;
use App\Http\Resources\API\Unit\UnitResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvMaterialsRequestResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        $requestMaterialsData = [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'class' => $this->class,
            'name' => $this->name,
            'code' => $this->code,
            'specification' => $this->specification !== null && $this->specification !== 'NULL' ? $this->specification : '',
            'unit_id' =>  new UnitResources($this->units),
        ];
        // dd($this);
        if ($this->materialsRequestDetails) {
            // dd($this->materialsRequestDetails);
            $history = $this->materialsRequestDetails->where('material_requests_id', $this->material_request_id)->first(); // Assuming you only want the first history entry
            if ($history) {
                $requestMaterialsData += [
                    'history_id' => $history->id,
                    'history_uuid' => $history->uuid,
                    'materials_id' => $history->materials_id,
                    'inventories_id' => $history->inventories_id,
                    'date' => $history->date ?? '',
                    'qty' => $history->qty ?? '',
                    'projects_id' => $history->projects_id ?? '',
                    'sub_projects_id' => $history->sub_projects_id ?? '',
                    'remarks' => $history->remarks,
                    'activities_id' => new ActiviteiesResources($history->activites) ?? '',
                ];
            } else {
                $requestMaterialsData += [
                    'history_id' => '',
                    'history_uuid' => '',
                    'materials_id' => '',
                    'inventories_id' => '',
                    'activities_id' => '',
                    'date' => '',
                    'qty' => '',
                    'projects_id' => '',
                    'sub_projects_id' => '',
                    'remarks' => '',
                ];
            }
        }

        return $requestMaterialsData;




        // **********************************************************************************
        // $material = $this['material'];
        // $materialRequest = $this['material_request'] ?? null;
        // dd($material, $materialRequest);
        // $resource = [
        //     'material' => [
        //         'id' => $material->id,
        //         'project_id' => new ProjectResource($material->projects),
        //         'store_id' => new StoreResources($material->stores),
        //         'opeing_stock_date' => $material->opeing_stock_date,
        //         'material_id' => new MaterialsResources($material->materials),
        //         'qty' => $material->qty
        //     ]
        // ];

        // $resource = [
        //     'material' => [
        //         'id' => $material->id,
        //         'name' => $material->name,
        //         'class' => $material->class,
        //         'code' => $material->code,
        //         'specification' => $material->specification,
        //         'unit_id' => new UnitResources($material->units)
        //     ]
        // ];

        // if ($materialRequest) {
        //     $resource['material']['request'] = [
        //         'id' => $materialRequest->id,
        //         'materials_id' => new MaterialsResources($materialRequest->materials),
        //         'inventories_id' => new InventoryResources($materialRequest->inventory),
        //         'activities_id' => new ActiviteiesResources($materialRequest->activites),
        //         'qty' => $materialRequest->qty,
        //         'remarks' => $materialRequest->remarks,
        //     ];
        // }
        // return $resource;

    }
}


// array:2 [ // app\Http\Controllers\API\inventory\MaterialRequestController.php:206
//     0 => array:13 [
//       "id" => 1
//       "uuid" => "e3c19d43-94bf-417a-b158-0f77911417ad"
//       "name" => "aser"
//       "class" => "Class-A"
//       "code" => "6653baa71e6e18"
//       "specification" => "aaaaaaaaa"
//       "unit_id" => 1
//       "company_id" => 1
//       "is_active" => 1
//       "deleted_at" => null
//       "created_at" => "2023-10-27T12:17:53.000000Z"
//       "updated_at" => "2023-10-27T12:17:53.000000Z"
//       "materials_request" => array:2 [
//         0 => array:14 [
//           "id" => 3
//           "uuid" => "3f5dafaf-85f9-45ae-8c00-fe151f07d61f"
//           "materials_id" => 1
//           "inventories_id" => 1
//           "activities_id" => 139
//           "date" => null
//           "qty" => 12123
//           "projects_id" => 3
//           "sub_projects_id" => 1
//           "remarks" => "sssssssssssssssssssssssssssssss"
//           "company_id" => 1
//           "is_active" => 1
//           "created_at" => "2024-03-14T14:17:33.000000Z"
//           "updated_at" => "2024-03-14T14:17:33.000000Z"
//         ]
//         1 => array:14 [
//           "id" => 4
//           "uuid" => "f176f0c6-3d0e-45f1-b498-f67359446a57"
//           "materials_id" => 1
//           "inventories_id" => 1
//           "activities_id" => 138
//           "date" => null
//           "qty" => 1233
//           "projects_id" => 3
//           "sub_projects_id" => 1
//           "remarks" => "sssssssssssssssssssssssssssssss"
//           "company_id" => 1
//           "is_active" => 1
//           "created_at" => "2024-03-14T14:17:33.000000Z"
//           "updated_at" => "2024-03-14T14:17:33.000000Z"
//         ]
//       ]
//     ]
//     1 => array:13 [
//       "id" => 2
//       "uuid" => "4f5ba1f2-8180-417d-a86c-cb7d4aae2a21"
//       "name" => "aserwe"
//       "class" => "Class-B"
//       "code" => "6653bab4dd7f0d"
//       "specification" => "aaaaaaaaa"
//       "unit_id" => 1
//       "company_id" => 1
//       "is_active" => 1
//       "deleted_at" => null
//       "created_at" => "2023-10-27T12:21:33.000000Z"
//       "updated_at" => "2023-10-27T12:27:35.000000Z"
//       "materials_request" => []
//     ]
//   ]
