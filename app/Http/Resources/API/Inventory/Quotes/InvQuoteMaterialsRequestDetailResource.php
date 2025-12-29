<?php

namespace App\Http\Resources\API\Inventory\Quotes;

use App\Http\Resources\API\Activities\ActiviteiesResources;
use App\Http\Resources\API\Inventory\MaterialRequest\MaterialRequestResources;
use App\Http\Resources\API\Unit\UnitResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvQuoteMaterialsRequestDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $requestMaterialsData = [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'class' => $this->class,
            'name' => $this->name,
            'code' => $this->code,
            'specification' => $this->specification !== null && $this->specification !== 'NULL' ? $this->specification : '',
            'unit' => new UnitResources($this->units),
            'price' => $this->price !== null ? $this->price : 0.00,
        ];
        // dd($this->materialsRequestDetails->where('material_requests_id',$this->material_requests_id)->first());
        if ($this->materialsRequestDetails) {
            $history = $this->materialsRequestDetails->where('material_requests_id', $this->material_requests_id)->first(); // Assuming you only want the first history entry
            // dd($history->materialrequest->hasonequotesDetails->price);
            // dd($history->materialrequest->hasonequotesDetails->request_qty);
            if ($history) {
                $requestMaterialsData += [
                    'materials_request_details_id' => $history->id,
                    'materials_request_details_uuid' => $history->uuid,
                    'materials_id' => $history->materials_id,
                    'material_requests_id' => $history->materialrequests->id,
                    'inventories_id' => $history->inventories_id,
                    'date' => $history->date ?? '',
                    'qty' => $history->qty ?? '',
                    'projects_id' => $history->projects_id ?? '',
                    'sub_projects_id' => $history->sub_projects_id ?? '',
                    'remarks' => $history->remarks !== null ? $history->remarks : '',
                    'price' => $history->materialrequest->hasonequotesDetails->price ?? 0.00,
                    'request_qty' => $history->materialrequest->hasonequotesDetails->request_qty ?? 0.00,
                    'material_requests' => new MaterialRequestResources($history->materialrequests),
                    'activities_id' => new ActiviteiesResources($history->activites) ?? '',
                ];
            } else {
                $requestMaterialsData += [
                    'materials_request_details_id' => '',
                    'materials_request_details_uuid' => '',
                    'materials_id' => '',
                    'inventories_id' => '',
                    'activities_id' => '',
                    'date' => '',
                    'qty' => '',
                    'price' => '',
                    'request_qty' => '',
                    'projects_id' => '',
                    'sub_projects_id' => '',
                    'remarks' => '',
                ];
            }
        }

        return $requestMaterialsData;
    }
}
