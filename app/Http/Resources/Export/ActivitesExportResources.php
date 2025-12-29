<?php

namespace App\Http\Resources\Export;

use App\Http\Resources\API\Activities\ActiviteiesResources;
use App\Http\Resources\API\Project\ProjectResource;
use App\Http\Resources\API\SubProject\SubProjectResources;
use App\Http\Resources\API\Unit\UnitResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivitesExportResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id ?? '',
            "uuid" => $this->uuid ?? '',
            'project' => $this->project->uuid ?? '',
            'subproject' => $this->subproject->uuid ?? '',
            'type' => $this->type ?? '',
            'sl_no' => $this->sl_no ?? '',
            'activities' => $this->activities ?? '',
            'unit_name' => $this->units?->unit ?? '',
            'qty' => $this->qty ?? '',
            'rate' => $this->rate ?? '',
            'amount' => $this->amount ?? '',
            'start_date' => $this->start_date ?? '',
            'end_date' => $this->end_date ?? '',
            'unit_id' => $this->units?->uuid ?? '',
        ];
    }
}
