<?php

namespace App\Http\Resources\API\Teams;

use App\Http\Resources\Common\CityResources;
use App\Http\Resources\Common\CountryResources;
use App\Http\Resources\Common\StateResources;
use App\Http\Resources\Role\RoleResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->reportingPerson->name);
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
            'reporting_person' => $this->reportingPerson->name ?? '',
            'dob' => $this->dob,
            'country' =>  new CountryResources($this->countries) ?? '',
            'state' => new StateResources($this->states) ?? '',
            'city' => new CityResources($this->cities) ?? '',
            'profile_images' => $this->profile_images,
            'company_role' => new RoleResources($this->companyUserRole),
        ];
    }
}
