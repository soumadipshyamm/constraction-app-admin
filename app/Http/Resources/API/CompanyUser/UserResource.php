<?php

namespace App\Http\Resources\API\CompanyUser;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name??'',
            'country_code' => $this->country_code??'',
            'phone' => $this->phone??'',
            'email' => $this->email??'',
            // 'password' => $this->password,
            'country' => $this->country??'',
            'city' => $this->city??'',
            'dob' => $this->dob??'',
            'designation' => $this->designation??'',
            // 'company_role_id' => $this->company_role_id,
            'profile_images' => $this->profile_images??'',
        ];
    }
}
