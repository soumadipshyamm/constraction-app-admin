<?php

namespace App\Http\Resources\API\Labours;

use App\Http\Resources\ActivitesResource;
use App\Http\Resources\API\Unit\UnitResources;
use App\Http\Resources\API\Vendor\VendorResources;
use App\Http\Resources\VendorResource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// class LabourHistoryResources extends JsonResource
// {
//     public function toArray($request)
//     {
//         $labour = $this['labour'];
//         $labourHistory = $this['labour_history'] ?? null;
//         $resource = [
//             'labour' => [
//                 'id' => $labour->id,
//                 'uuid' => $labour->uuid,
//                 'name' => $labour->name,
//                 'category' => $labour->category,
//                 'company_id' => $labour->company_id,
//                 'unit_id' =>  new UnitResources($labour->units),
//                 'is_active' => $labour->is_active,
//             ]
//         ];

//         if ($labourHistory) {
//             $resource['labour']['history'] = [
//                 'labour_history_id' => $labourHistory->id,
//                 'labour_labourHistory_uuid' => $labourHistory->uuid,
//                 'qty' => $labourHistory->qty,
//                 'ot_qty' => $labourHistory->ot_qty,
//                 'labours_id' => $labourHistory->labours->id,
//                 'labours_name' => $labourHistory->labours->name,
//                 'activities_id' => new ActivitesResource($labourHistory->activities) ?? [],
//                 'vendors_id' => new VendorResources($labourHistory->vendors) ?? [],
//                 'rate_per_unit' => $labourHistory->rate_per_unit,
//                 'dpr_id' => $labourHistory->dpr_id,
//                 'remarkes' => $labourHistory->remarkes,
//             ];
//         }

//         return $resource;
//     }
// }

class LabourHistoryResources extends JsonResource
{
    public function toArray($request)
    {
        // dd($this);
        $assetsData = [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'category' => $this->category,
            'company_id' => $this->company_id,
            'unit_id' =>  new UnitResources($this->units),
            'is_active' => $this->is_active,
        ];
        // dd($this->labourHistory);

        if ($this->labourHistory) {
            $history = $this->labourHistory->first(); // Assuming you only want the first history entry
            // dd($history);
            if ($history) {
                // dd($history->activities_id);
                $assetsData += [
                    'labour_history_id' => $history->id,
                    'labour_history_uuid' => $history->uuid,
                    'qty' => $history->qty ?? 0,
                    'ot_qty' => $history->ot_qty ?? 0,
                    'labours_id' => $history->labours->id,
                    'labours_name' => $history->labours->name,
                    // 'activities_id' => $history->activities_id,
                    'activities_id' => new ActivitesResource($history->activities) ?? [],
                    'vendors_id' => new VendorResources($history->vendors) ?? [],
                    // 'vendors_id' => $history->vendors->id,
                    // 'vendors_name' => $history->vendors->name,
                    'rate_per_unit' => $history->rate_per_unit ?? 0,
                    'dpr_id' => $history->dpr_id,
                    'remarkes' => $history->remarkes,
                ];
            } else {
                $assetsData += [
                    'labour_history_id' => '',
                    'labour_history_uuid' => '',
                    'qty' => 0,
                    'ot_qty' => 0,
                    'labours_id' => '',
                    'labours_name' => '',
                    'activities_id' => '',
                    'activities_name' => '',
                    'vendors_id' => '',
                    'vendors_name' => '',
                    'rate_per_unit' => 0,
                    'dpr_id' => '',
                    'remarkes' => '',
                ];
            }
        }

        return $assetsData;
    }
}
