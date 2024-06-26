<?php

namespace App\Http\Resources\API\Project;

use App\Http\Resources\API\Client\ClientResources;
use App\Http\Resources\API\Companies\CompaniesResources;
use App\Http\Resources\API\SubProject\SubProjectResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->companys);
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
            'companies' => isset($this->companys) ? new CompaniesResources($this->companys) : '',
            'client' => isset($this->client) ? new ClientResources($this->client) : '',
            'logo' => url('/logo/' . $this->logo),
            // 'companies_id' => $this->companies_id,
            // 'sub_project' => SubProjectResources::collection($this->whenLoaded('subProject')),
        ];
    }
}
