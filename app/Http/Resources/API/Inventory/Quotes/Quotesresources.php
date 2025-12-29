<?php

namespace App\Http\Resources\API\Inventory\Quotes;

use App\Http\Resources\API\Project\ProjectResource;
use App\Http\Resources\MaterialsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Quotesresources extends JsonResource
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
            'projects_id' => new ProjectResource($this->projects),
            'materials_id' => $this->materials_id,
            'material_requests_id' => $this->material_requests_id,
            'activities_id' => $this->activities_id,
            'date' => $this->date,
            'qty' => $this->qty,
            'remarks' => $this->remarks !== null && $this->remarks !== 'NULL' ? $this->remarks : '',
            // 'materials' => MaterialsResource::collection($this->materials)
        ];
    }
}
