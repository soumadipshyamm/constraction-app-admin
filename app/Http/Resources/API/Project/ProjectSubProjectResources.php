<?php

namespace App\Http\Resources\API\Project;

use App\Http\Resources\API\Client\ClientResources;
use App\Http\Resources\API\Companies\CompaniesResources;
use App\Http\Resources\API\SubProject\SubProjectResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectSubProjectResources extends JsonResource
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
            'project_name' => $this->project_name,
            'planned_start_date' => $this->planned_start_date,
            'address' => $this->address,
            'planned_end_date' => $this->planned_end_date,
            'own_project_or_contractor' => $this->own_project_or_contractor,
            'project_completed' => $this->project_completed,
            'project_completed_date' => $this->project_completed_date,
            'logo' => url('/logo/' . $this->logo),
            'companies' => isset($this->companys) ? new CompaniesResources($this->companys) : '',
            'client' => isset($this->client) ? new ClientResources($this->client) : '',
            // 'companies_id' => $this->companies_id,
            'sub_project' => new SubProjectResources($this->subProject[0]),
        ];
    }
}
