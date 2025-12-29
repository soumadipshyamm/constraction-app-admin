<?php

namespace App\Http\Resources\API\Inventory\InwardGoods;

use App\Http\Resources\API\CompanyUser\UserResource;
use App\Http\Resources\API\Project\ProjectResource;
use App\Http\Resources\API\Store\StoreResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InwardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->InvInwardStore);
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'date' => $this->date,
            'details' => $this->details !== null ? $this->details : '',
            'remarks' => $this->remarks !== null ? $this->remarks : '',
            'projects_id' => new  ProjectResource($this->projects),
            'store_id' =>  StoreResources::collection($this->InvInwardStore),
            'user_id' => new UserResource($this->users),

        ];
    }
}
