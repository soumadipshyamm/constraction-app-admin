<?php

namespace App\Http\Resources\API\Safety;

use App\Http\Resources\API\CompanyUser\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SafetyResouces extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->companyUsers);
        return [
            "id" => $this->id,
            "uuid" => $this->uuid,
            "name" => $this->name,
            "date" => $this->date,
            "details" => $this->details !== null ? $this->details : '',
            "remarks" => $this->remarks !== null ? $this->remarks : '',
            "company_users_id" => $this->companyUsers != null ? new UserResource($this->companyUsers) : '',
            "projects_id" => $this->projects_id,
            "sub_projects_id" => $this->sub_projects_id,
            "dpr_id" => $this->dpr_id,
            "img" => $this->img ? url('/upload/' . $this->img):'',
            "company_id" => $this->company_id,
            "is_active" => $this->is_active,
        ];
    }
}
