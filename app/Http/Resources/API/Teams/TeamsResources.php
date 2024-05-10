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
        // dd($this);
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone,
            'alternet_phone' => $this->alternet_phone,
            'address' => $this->address,
            'designation' => $this->designation,
            'aadhar_no' => $this->aadhar_no,
            'pan_no' => $this->pan_no,
            'reporting_person' => $this->reporting_person,
            'dob' => $this->dob,
            'country' =>  new CountryResources($this->countries) ?? '',
            'state' => new StateResources($this->states) ?? '',
            'city' => new CityResources($this->cities) ?? '',
            'profile_images' => $this->profile_images,
            'company_role' => new RoleResources($this->companyUserRole),
        ];
    }
}



// "id": 2,
//             "uuid": "88e00d81-5837-4a52-8039-8ed1d422e452",
//             "name": "ankur",
//             "email": "abcd@abc.com",
//             "password": "$2y$10$CqC7KprtzL24PSNBWYjMnuA5fih3Lip/oN.y3oHEwNb3cBRebLsWu",
//             "phone": "1234567890",
//             "alternet_phone": null,
//             "address": null,
//             "designation": "dev",
//             "aadhar_no": null,
//             "pan_no": null,
//             "reporting_person": null,
//             "dob": "12/12/2021",
//             "country": "WB",
//             "state": null,
//             "city": "kolkata",
//             "otp_no": null,
//             "otp_verify": "yes",
//             "profile_images": null,
//             "company_role_id": 6,
//             "company_id": 2,
//             "is_active": 1,
//             "created_at": "2023-10-03T13:09:31.000000Z",
//             "updated_at": "2023-10-03T13:09:44.000000Z",
//             "deleted_at": null
