<?php

namespace App\Http\Resources\API\Inventory\Quotes;

use App\Http\Resources\API\Inventory\MaterialRequest\MaterialRequestResources;
use App\Http\Resources\API\Materials\MaterialsResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotesMaterialsDetailsresources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        $datass = [
            'id' => $this->material_requests_id ?? '',
            'quort_details_id' => $this->id,
            'uuid' => $this->uuid,
            'quotes_id' => $this->quotes_id,
            'request_no' => $this->request_no,
            'date' => $this->date,
            'img' => $this->img,
            'remarkes' => $this->remarkes !== null && $this->remarkes !== 'NULL' ? $this->remarkes : '',
            'company_id' => $this->company_id,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'material_requests' => new MaterialRequestResources($this->materialsRequest),

        ];

        return $datass;
    }
}
