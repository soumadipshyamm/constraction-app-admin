<?php

namespace App\Http\Resources\API\Activities;

use App\Http\Resources\ActivitesResource;
use App\Http\Resources\API\Companies\CompaniesResources;
use App\Http\Resources\API\Unit\UnitResources;
use App\Http\Resources\API\Vendor\VendorResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// class DprActivitesResources extends JsonResource
// {

//     public function toArray($request)
//     {
//         $activity = $this['activity'];
//         $activityHistory = $this['activity_history'] ?? null;

//         $resource = [
//             'activity' => [
//                 'id' => $activity->id,
//                 'uuid' => $activity->uuid,
//                 'qty' => $activity->qty,
//                 'project_id' => $activity->project_id,
//                 'subproject_id' => $activity->subproject_id,
//                 'type' => $activity->type,
//                 'total_qty' => $activity->total_qty,
//                 'remaining_qty' => $activity->remaining_qty,
//             ]
//         ];

//         if ($activityHistory) {
//             $resource['activity']['history'] = [
//                 'id' => $activityHistory->id,
//                 'uuid' => $activityHistory->uuid,
//                 'activities_id' => $activityHistory->activites_id,
//                 'qty' => $activityHistory->qty,
//                 // Add other fields specific to activity history here
//             ];
//         }

//         return $resource;
//     }
// }

class DprActivitesResources extends JsonResource
{
    public function toArray($request)
    {
        // dd($this);
        $activitesData = [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'qty' => (!empty($this->qty))?$this->qty: "0",
            'project_id' => $this->project_id,
            'subproject_id' => $this->subproject_id,
            'type' => $this->type,
            'activities' => $this->activities,
            'total_qty' => $this->total_qty,
            'units' => new UnitResources($this->units) ?? '',
            'remaining_qty' => $this->remaining_qty,
        ];

        if ($this->activitiesHistory) {
            $history = $this->activitiesHistory->first();
            if ($history) {
                $activitesData += [
                    'activities_history_id' => $history->id,
                    'activities_history_uuid' => $history->uuid,
                    'activities_history_activities_id' => $history->activities_id,
                    'activities_history_activities_name' => $history->activities->activities,
                    'activities_history_qty' => $history->qty,
                    'activities_history_total_qty' => $history->total_qty,
                    'activities_history_remaining_qty' => $history->remaining_qty,
                    'activities_history_completion' => $history->completion,
                    'activities_history_vendors_id' => $history->vendors_id,
                    'activities_history_vendors_name' => $history->vendors->name,
                    'activities_history_img' => $history->img,
                    'activities_history_remarkes' => $history->remarkes,
                    'activities_history_dpr_id' => $history->dpr_id,
                ];
            } else {
                $activitesData += [
                    'activities_history_id' => '',
                    'activities_history_uuid' => '',
                    'activities_history_activities_id' => '',
                    'activities_history_activities_name' => '',
                    'activities_history_qty' => 0,
                    'activities_history_total_qty' => '0',
                    'activities_history_remaining_qty' => '0',
                    'activities_history_completion' => 0,
                    'activities_history_vendors_id' => '',
                    'activities_history_vendors_name' => '',
                    'activities_history_img' => '',
                    'activities_history_remarkes' => '',
                    'activities_history_dpr_id' => '',
                ];
            }
        }

        return $activitesData;
    }
}
