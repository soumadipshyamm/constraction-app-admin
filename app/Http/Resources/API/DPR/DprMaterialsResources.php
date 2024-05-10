<?php

namespace App\Http\Resources\API\DPR;

use App\Http\Resources\ActivitesResource;
use App\Http\Resources\API\Activities\ActiviteiesResources;
use App\Http\Resources\API\Unit\UnitResources;
use App\Http\Resources\MaterialsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// class DprMaterialsResources extends JsonResource
// {

//     public function toArray($request)
//     {

//         $material = $this['material'];
//         $materialHistory = $this['material_history'] ?? null;

//         // dd($this);
//         $resource = [
//             'material' => [
//                 'id' => $material->id,
//                 'uuid' => $material->uuid,
//                 'code' => $material->code,
//                 'unit_id' => new UnitResources($material->units),
//                 'class' => $material->class,
//                 'name' => $material->name,
//                 'specification' => $material->specification,
//             ]
//         ];
//         if ($materialHistory) {
//             $resource['material']['history'] = [
//                 'materials_history_id' => $materialHistory->id,
//                 'materials_history_uuid' => $materialHistory->uuid,
//                 'materials_id' => $materialHistory->materials_id,
//                 'activities_id' => new ActivitesResource($materialHistory->activities) ?? [],
//                 'qty' => $materialHistory->qty,
//                 'materials_history_date' => $materialHistory->date,
//                 'remarkes' => $materialHistory->remarkes,
//                 'dpr_id' => $materialHistory->dpr_id,
//             ];
//         }
//         return $resource;
//     }
// }


class DprMaterialsResources extends JsonResource
{

    public function toArray($request)
    {
        $materialData = [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'code' => $this->code,
            'unit_id' => new UnitResources($this->units),
            'class' => $this->class,
            'name' => $this->name,
            'specification' => $this->specification,
        ];
        if ($this->materialsHistory) {
            $history = $this->materialsHistory->first(); // Assuming you only want the first history entry
            if ($history) {
                $materialData += [
                    'materials_history_id' => $history->id,
                    'materials_history_uuid' => $history->uuid,
                    'materials_id' => $history->materials_id,
                    'activities_id' => new ActivitesResource($history->activities) ?? [],
                    'qty' => $history->qty,
                    'materials_history_date' => $history->date,
                    'remarkes' => $history->remarkes,
                    'dpr_id' => $history->dpr_id,
                ];
            } else {
                $materialData += [
                    'materials_history_id' => '',
                    'materials_history_uuid' => '',
                    'materials_id' => '',
                    'activities_id' => '',
                    'activities_name' => '',
                    'qty' => '',
                    'materials_history_date' => '',

                    'remarkes' => '',
                    'dpr_id' => '',
                ];
            }
        }

        return $materialData;
    }
}
