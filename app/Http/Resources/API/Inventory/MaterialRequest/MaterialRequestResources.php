<?php

namespace App\Http\Resources\API\Inventory\MaterialRequest;

use App\Http\Resources\API\Activities\ActiviteiesResources;
use App\Http\Resources\API\Materials\MaterialsResources;
use App\Http\Resources\API\Project\ProjectResource;
use App\Http\Resources\API\SubProject\SubProjectResources;
use App\Models\Company\Materials;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialRequestResources extends JsonResource
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
            'materials_id' => new MaterialsResources($this->materials),
            'inventories_id' =>  $this->inventories_id,
            'activities_id' => new ActiviteiesResources($this->activites),
            'date' => $this->date,
            'qty' => $this->qty,
            'projects_id' => new ProjectResource($this->projects),
            // 'sub_projects_id' => new SubProjectResources($this->subProject),
            'remarks' => $this->remarks,
            'company_id' => $this->company_id,
            'is_active' => $this->is_active,
        ];
    }
}

// projects
// stores
// inventory
// activites
// subProject
