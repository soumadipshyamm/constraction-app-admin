<?php

namespace App\Http\Resources\API\Inventory\Quotes;

use App\Http\Resources\API\Vendor\VendorResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotesMaterialRequestSendVendorResource extends JsonResource
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
            'vendors_id' => $this->vendors_id,
            'quotes_details_id' => $this->quotes_details_id,
            'quotes_id' => $this->quotes_id,
            'type' => $this->type,
            'company_id' => $this->company_id,
            'uuid' => $this->uuid,
            'request_no' => $this->request_no,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'vendors' => new VendorResources($this->vendorlist)
            // Add any additional fields you want to include
        ];
    }
}
