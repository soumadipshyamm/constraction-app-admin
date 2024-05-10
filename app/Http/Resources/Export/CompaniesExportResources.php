<?php

namespace App\Http\Resources\Export;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompaniesExportResources extends JsonResource
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
            'registration_name' => $this->registration_name ?? (object)[],
            'company_registration_no' => $this->company_registration_no ?? (object)[],
            'registered_address' => $this->registered_address ?? (object)[],
        ];
    }
}
