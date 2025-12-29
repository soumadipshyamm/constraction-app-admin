<?php

namespace App\Http\Resources\DPR;

use App\Http\Resources\API\Activities\ActiviteiesResources;
use App\Http\Resources\API\Vendor\VendorResources;
use App\Http\Resources\AssetsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DprAssetsResources extends JsonResource
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
            'qty' => $this->qty,
            'dpr_no' => $this->dpr_no ?? '',
            'assets' => new AssetsResource($this->assets),
            "activities" => new ActiviteiesResources($this->activities),
            "vendors" => new VendorResources($this->vendors),
            'rate_per_unit' => $this->rate_per_unit,
            'dpr_id' => $this->dpr_id,
            'remarkes' => $this->remarkes !== null ? $this->remarkes : '',
        ]);
    }
}


// "qty": 2,
//             "assets_id": 1,
//             "activities_id": 138,
//             "vendors_id": 1,
//             "rate_per_unit": 13,
//             "dpr_id": 12,
//             "remarkes": "testtttt"
