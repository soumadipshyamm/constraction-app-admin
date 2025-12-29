<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // '#'=> random_int(1,5000),
            'id'=>$this->id,
            'uuid'=>$this->uuid,
            'name'=>$this->name,
            'type'=>$this->type,
            'gst_no'=>$this->gst_no,
            'address'=>$this->address,
            'contact_person_name'=>$this->contact_person_name,
            'country_code' => $this->country_code,
            'phone'=>$this->phone,
            'email'=>$this->email,
            // 'name'=>$this->additional_fields,
        ];
    }
}
