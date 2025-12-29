<?php

namespace App\Http\Resources\API\Companies;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompaniesResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this);
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'registration_name' => $this->registration_name ?? (object)[],
            'company_registration_no' => $this->company_registration_no ?? (object)[],
            'registered_address' => $this->registered_address ?? (object)[],
            'logo' => isset($this->logo) ? url('/logo/' . $this->logo) : '',
        ];
    }
}
