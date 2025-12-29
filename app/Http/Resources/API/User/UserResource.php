<?php

namespace App\Http\Resources\API\User;

use App\Http\Resources\API\Company\CompanyResource;
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
        // dd($this['user']);
        return [
            'token' => $this['token'],
            'id' => $this['user']->id,
            'uuid' => $this['user']->uuid,
            'name' => $this['user']->name,
            'email' => $this['user']->email,
            'country_code' => $this['user']->country_code,
            'phone' => $this['user']->phone,
            'designation' => $this['user']->designation,
            'dob' => $this['user']->dob,
            'country' => $this['user']->country,
            'city' => $this['user']->city,
            'company_role_id' => $this['user']->company_role_id,
            'company_role' => $this['user']->companyUserRole,
            'company' => new CompanyResource($this['user']->company),
            'is_active' => $this['user']->is_active,
        ];
    }
}
