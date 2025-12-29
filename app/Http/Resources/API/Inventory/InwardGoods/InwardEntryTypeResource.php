<?php

namespace App\Http\Resources\API\Inventory\InwardGoods;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InwardEntryTypeResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'remarkes' => $this->remarkes !== null ? $this->remarkes : '',

        ];
    }
}
