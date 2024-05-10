<?php

namespace App\Http\Resources\API\Company;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'registration_no' => $this->registration_no,
            'address' => $this->address,
            'phone' => $this->phone,
            'website_link' => $this->website_link,
        ];
    }
}
