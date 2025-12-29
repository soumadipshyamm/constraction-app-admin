<?php

namespace App\Http\Resources\Export;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectsExportResources extends JsonResource
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
            'project_name' => $this->project_name,
            'planned_start_date' => $this->planned_start_date,
            'address' => $this->address,
            'planned_end_date' => $this->planned_end_date,
            'own_project_or_contractor' => $this->own_project_or_contractor,
            'project_completed' => $this->project_completed,
            'project_completed_date' => $this->project_completed_date,
            // 'companies' => isset($this->companys) ? new CompaniesResources($this->companys) : '',
            // 'client' => isset($this->client) ? new ClientResources($this->client) : '',

        ];
    }
}
