<?php

namespace App\Http\Resources\API\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResources extends JsonResource
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
            'client_name' => $this->client_name,
            'client_designation' => $this->client_designation,
            'client_email' => $this->client_email,
            'country_code' => $this->country_code,
            'company_country_code' => $this->company_country_code,
            'client_phone' => $this->client_phone,
            'client_mobile' => $this->client_mobile,
            'client_company_name' => $this->client_company_name,
            'client_company_address' => $this->client_company_address,
        ];
    }
}
