<?php

namespace App\Http\Resources\API\Materials;

use App\Http\Resources\API\Unit\UnitResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use PhpParser\Node\Expr\Cast\Object_;

class MaterialsResources extends JsonResource
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
            "uuid" => $this->uuid,
            "name" => $this->name,
            "class" => $this->class,
            "code" => $this->code,
            "specification" => ($this->specification !== null && $this->specification !== "NULL") ? $this->specification : '',
            'unit_id' => $this->units ? new UnitResources($this->units) : (object)[]
        ];
    }
}
