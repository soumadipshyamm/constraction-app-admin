<?php

namespace App\Http\Resources\API\Vendor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $additional_fields = is_array($this->additional_fields) ? $this->additional_fields : json_decode($this->additional_fields);
        // $additional_fields = $this->additional_fields ? (json_decode($this->additional_fields)) : '';
        // dd( $additional_fields);
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'gst_no' => $this->gst_no,
            'address' => $this->address,
            'type' => $this->type,
            'contact_person_name' => $this->contact_person_name,
            'country_code' => $this->country_code,
            'phone' => $this->phone,
            'email' => $this->email,
            'company_id' => $this->company_id,
            'additional_fields' => (array)(object)$additional_fields,
        ];
    }
}
