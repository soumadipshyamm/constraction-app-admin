<?php

namespace App\Http\Resources;

use App\Http\Resources\API\Activities\ActiviteiesResources;
use App\Http\Resources\API\Inventory\MaterialRequest\MaterialRequestDetailsResources;
use App\Http\Resources\API\Materials\MaterialsResources;
use App\Http\Resources\API\Project\ProjectResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class pendingApprovalResource extends JsonResource
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
            'request_no' => $this->request_id ?? '',
            'inventories_id' =>  $this->inventories_id,
            'date' => $this->date,
            'qty' => $this->qty,
            'remarks' => $this->remarks !== null ? $this->remarks : '',
            'company_id' => $this->company_id,
            'is_active' => $this->is_active,
            'status' => $this->status,
            'created_by' => $this->users->name,
            'projects_id' => new ProjectResource($this->projects),
            'materials_id' => new MaterialsResources($this->materials),
            'activities_id' => new ActiviteiesResources($this->activites),
            'material_requests_id' => new MaterialRequestDetailsResources($this->materialRequestDetails),
        ];
    }
}
