<?php

namespace App\Http\Resources\API\DPR;

use App\Http\Resources\API\Activities\ActiviteiesResources;
use App\Http\Resources\API\Vendor\VendorResources;
use App\Http\Resources\LaboursResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DprLabourResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return ([
            'id' => $this->id,
            'uuid' => $this->uuid,
            'dpr_no' => $this->dpr_no ?? '',
            "qty" => $this->qty,
            'dpr_no' => $this->dpr_no ?? '',
            "ot_qty" => $this->ot_qty,
            "labours" => new LaboursResource($this->labours),
            "activities" => new ActiviteiesResources($this->activities),
            "vendors" => new VendorResources($this->vendors),
            "rate_per_unit" => $this->rate_per_unit,
            "remarkes" => $this->remarkes,
            "dpr_id" => $this->dpr_id,
        ]);
    }
}

// "qty": 2,
//     "ot_qty": 25,
//     "labours_id": 3,
//     "activities_id": 137,
//     "vendors_id": 1,
//     "rate_per_unit": 14,
//     "remarkes": "testtttt",
//     "dpr_id": 12
