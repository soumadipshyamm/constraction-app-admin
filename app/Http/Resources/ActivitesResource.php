<?php

namespace App\Http\Resources;

use App\Http\Resources\API\Activities\ActiviteiesResources;
use App\Http\Resources\API\Activities\DprActivitesResources;
use App\Http\Resources\API\Project\ProjectResource;
use App\Http\Resources\API\SubProject\SubProjectResources;
use App\Http\Resources\API\Unit\UnitResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivitesResource extends JsonResource
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
            "id" => $this->id,
            "uuid" => $this->uuid ?? '',
            // "parent_id" => $this->parent_id ?? '',
            // 'heading' => isset($this->parent_id) ? $this->whenLoaded('parent_id') : '',
            // 'parent' => isset($this->parentActivites) ? new ActiviteiesResources($this->whenLoaded('parentActivites')) : "",
            'children' =>  isset($this->parentActivites) ? ActiviteiesResources::collection($this->whenLoaded('childrenActivites')) : "",
            "sl_no" => $this->sl_no ?? '',
            "type" => $this->type !== null && $this->type !== 'NULL' ? $this->type ?? '' : '',
            "activities" => $this->activities !== null && $this->activities !== 'NULL' ? $this->activities ?? '' : '',
            "qty" => $this->qty !== null && $this->qty !== 'NULL' ? $this->qty ?? '' : '',
            "rate" => $this->rate !== null && $this->rate !== 'NULL' ? $this->rate ?? '' : '',
            "amount" => $this->amount !== null && $this->amount !== 'NULL' ? $this->amount ?? '' : '',
            "start_date" => $this->start_date !== null && $this->start_date !== 'NULL' ? $this->start_date ?? '' : '',
            "end_date" => $this->end_date !== null && $this->end_date !== 'NULL' ? $this->end_date ?? '' : '',
            'unit_id' => isset($this->units) ? new UnitResources($this->units) : '',
            'project' => isset($this->project) ? new ProjectResource($this->project) : "",
            'subproject' => isset($this->subproject) ? new SubProjectResources($this->subproject) : '',
            // 'dpr_activites' => isset($this->activitiesHistory) ? DprActivitesResources::collection($this->activitiesHistory) : ''
        ];
    }
}
