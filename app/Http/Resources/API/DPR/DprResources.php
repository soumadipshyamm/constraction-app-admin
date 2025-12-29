<?php

namespace App\Http\Resources\API\DPR;

use App\Http\Resources\API\Activities\DprActivitesResources;
use App\Http\Resources\API\Assets\AssetsResources;
use App\Http\Resources\API\Company\CompanyResource;
use App\Http\Resources\API\CompanyUser\UserResource;
use App\Http\Resources\API\Labours\LaboursResources;
use App\Http\Resources\API\Materials\MaterialsResources;
use App\Http\Resources\API\Project\ProjectResource;
use App\Http\Resources\API\SubProject\SubProjectResources;
use App\Http\Resources\MaterialsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DprResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd(new UserResource($this->users));
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'dpr_no' => $this->dpr_no ?? '',
            'staps' => $this->staps,
            'is_active' => $this->is_active,
            'projects_id' => $this->projects ? new ProjectResource($this->projects) : [],
            'sub_projects_id' => $this->subProjects ? new SubProjectResources($this->subProjects) : [],
            'activities_id' => isset($this->activities_id) ? new DprActivitesResources($this->activities) : [],
            'assets_id' => isset($this->assets_id) ? new AssetsResources($this->assets) : [],
            'labours_id' => isset($this->labours_id) ? new LaboursResources($this->labour) : [],
            "users" => isset($this->user_id) ? new UserResource($this->users) : [],
            // "users" => isset($this->materials_id) ? new MaterialsResources($this->material) : [],
            "materials_id" => isset($this->materials_id) ? new MaterialsResources($this->material) : [],

        ];
    }
}

// "activities_id" => null
// "assets_id" => null
// "labours_id" => null
// "materials_id" => null
// "safeties_id" => null
// "hinderance_id" => null
// "company_id" => 1
