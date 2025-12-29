<?php

namespace App\Http\Resources\API\Store;

use App\Http\Resources\API\Project\ProjectResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResources extends JsonResource
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
            "name" => $this->name,
            "location" => $this->location,
            'img' => url('/logo/' . $this->logo),
            "projects" => isset($this->project) ? new ProjectResource($this->project) : '',
        ];
    }
}
