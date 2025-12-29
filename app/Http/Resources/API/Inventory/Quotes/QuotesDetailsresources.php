<?php

namespace App\Http\Resources\API\Inventory\Quotes;

use App\Http\Resources\API\Inventory\MaterialRequest\MaterialRequestResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotesDetailsresources extends JsonResource
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
            'materials_id' => $this->materials_id,
            'material_requests_id' => $this->material_requests_id,
            'request_no' => $this->request_no,
            'date' => $this->date,
            'img' => url('/') . '/upload/' . $this->img,
            'remarkes' => $this->remarkes !== null ? $this->remarkes : '',
            'quotes_id' => new Quotesresources($this->quotes),
        ];
    }
}
