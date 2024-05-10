<?php

namespace App\Http\Resources\API\Inventory\inventor;

use App\Http\Resources\API\Company\CompanyResource;
use App\Http\Resources\API\CompanyUser\UserResource;
use App\Http\Resources\API\Project\ProjectResource;
use App\Http\Resources\API\SubProject\SubProjectResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResources extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->projects);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'date' => $this->date,
            'details' => $this->details,
            'remarks' => $this->remarks,
            'projects_id' => new  ProjectResource($this->projects),
            'sub_projects_id' => new SubProjectResources($this->subprojects),
            'user_id' => new UserResource($this->users),
            'company_id' => new CompanyResource($this->company),
        ];
    }
}
