<?php

namespace App\Http\Resources\Api\Notifaction;

use App\Http\Resources\API\Company\CompanyResource;
use App\Http\Resources\API\CompanyUser\UserResource;
use App\Http\Resources\API\Project\ProjectResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotifactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ?? null,
            'message' => $this->message ?? null,
            'type' => $this->type ?? null,
            'details' => json_decode($this->details) !== null ? json_decode($this->details) : '',
            'remarks' => $this->remarks !== null ? $this->remarks : '',
            'user_id' => $this->user ? new UserResource($this->user) : [],
            'sender_id' => $this->sender ? new UserResource($this->user) : [],
            'company_id' => $this->company->name ?? null,
            'company' => $this->company ?? null,
            'project_id' => $this->project ? new ProjectResource($this->project) : [],
            'status' => $this->status ?? null,
            'created_at' => $this->created_at ?? null,
        ];
    }
}
