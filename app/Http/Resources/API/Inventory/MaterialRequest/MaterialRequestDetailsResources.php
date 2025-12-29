<?php

namespace App\Http\Resources\API\Inventory\MaterialRequest;

use App\Http\Resources\API\Activities\ActiviteiesResources;
use App\Http\Resources\API\Materials\MaterialsResources;
use App\Http\Resources\API\Project\ProjectResource;
use App\Http\Resources\API\SubProject\SubProjectResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialRequestDetailsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this);
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'projects' => new ProjectResource($this->projects),
            'sub_projects' => new SubProjectResources($this->subprojects),
            'material_requests' => new MaterialRequestResources($this->materialrequests),
            'materials' => new MaterialsResources($this->materials),
            'activities' => new ActiviteiesResources($this->activites),
            'date' => $this->date,
            'qty' => $this->qty,
            'remarks' => $this->remarks !== null ? $this->remarks : '',
            'company' => $this->company_id,
            // 'code' => $this->request_id,
        ];
    }
}
