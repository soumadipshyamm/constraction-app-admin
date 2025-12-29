<?php

namespace App\Http\Resources\API\Activities;

use App\Http\Resources\API\Project\ProjectResource;
use App\Http\Resources\API\SubProject\SubProjectResources;
use App\Http\Resources\API\Unit\UnitResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActiviteiesResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this);
        // dd($this->activitiesHistory->last());
        return [
            "id" => $this->id,
            "uuid" => $this->uuid,
            "parent_id" => $this->parent_id ?? '',
            "sl_no" => $this->sl_no ?? '',
            "type" => $this->type ?? '',
            "activities" => $this->activities ?? '',
            "qty" => $this->qty ?? '',
            "rate" => $this->rate ?? '',
            "amount" => $this->amount ?? '',
            "start_date" => $this->start_date ?? '',
            "end_date" => $this->end_date ?? '',
            'heading' => new ActiviteiesResources($this->parent) ?? '',
            // 'parent' => ($this->whenLoaded('parent')) ? new ActiviteiesResources($this->whenLoaded('parent')) : (object)[],
            // 'children' => ($this->whenLoaded('children')) ? ActiviteiesResources::collection($this->whenLoaded('children')) : (object)[],
            'unit_id' => ($this->units) ? new UnitResources($this->units) : (object)[],
            'project' => ($this->project) ? new ProjectResource($this->project) : (object)[],
            'subproject' => ($this->subproject) ? new SubProjectResources($this->subproject) : (object)[],
            // 'activitiesHistory' => ($this->activitiesHistory) ? DprActivitesResources::collection($this->activitiesHistory) : (object)[]
        ];
    }
}
