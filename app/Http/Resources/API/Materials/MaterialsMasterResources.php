<?php

namespace App\Http\Resources\API\Materials;

use App\Http\Resources\API\Unit\UnitResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MaterialsMasterResources extends JsonResource
{
    public function toArray(Request $request): array
    {
        // dd($this);
        return [
            "id" => $this->id,
            "uuid" => $this->uuid,
            "name" => $this->name,
            // "class" => $this->class,
            "class" => [
                "title" => "Class-" . $this->class,
                "value" => $this->class,
            ],
            "code" => $this->code,
            "specification" => ($this->specification !== null && $this->specification !== "NULL") ? $this->specification : '',
            'unit_id' => $this->units ? new UnitResources($this->units) : (object)[]
        ];
    }
}
