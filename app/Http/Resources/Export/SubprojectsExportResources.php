<?php

namespace App\Http\Resources\Export;

use App\Http\Resources\API\Project\ProjectResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubprojectsExportResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $projectName = new ProjectResource($this->project[0]);
        return  [
            'id' => $this->id,
            'name' => $this->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'project' => $projectName->project_name,
        ];
    }
}
