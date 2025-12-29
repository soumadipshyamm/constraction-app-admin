<?php

namespace App\Http\Resources\API\Profile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResources extends JsonResource
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
            'email' => $this->email,
            'password' => $this->password,
            'country_code' => $this->country_code,
            'phone' => $this->phone,
            'alternet_phone' => $this->alternet_phone,
            'address' => $this->address,
            'designation' => $this->designation,
            'aadhar_no' => $this->aadhar_no,
            'pan_no' => $this->pan_no,
            'reporting_person' => $this->reporting_person,
            'dob' => $this->dob,
            'otp_no' => $this->otp_no,
            'otp_verify' => $this->otp_verify,
            'profile_images' =>$this->profile_images? url('/profile_image/'.$this->profile_images):null,
            'company_role_id' => $this->company_role_id,
            'company_id' => $this->company_id,
            'is_active' => $this->is_active,
            // 'country' => $this->country,
            // 'state' => $this->state,
            // 'city' => $this->city,
            'country' => $this->countries,
            'state' => $this->states,
            'city' => $this->cities,
            'company' => $this->company,
        ];
    }
}
