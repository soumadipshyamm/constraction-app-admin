<?php

namespace App\Http\Resources\API\Inventory\ReturnGoods;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReturnListResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "uuid" => $this->uuid,
            "name" => $this->name,
            "date" => $this->date,
            "projects_id" => $this->projects_id,
            "store_id" => $this->store_id,
            "user_id" => $this->user_id,
            "company_id" => $this->company_id
        ];
    }
}


// "id": 1,
//             "uuid": "81565ca3-6e41-49a4-b166-c9b27741f6b0",
//             "name": "2024-03-07",
//             "date": "2024-03-21",
//             "details": null,
//             "remarks": null,
//             "projects_id": 1,
//             "store_id": 1,
//             "user_id": 2,
//             "company_id": 2,
//             "is_active": 1,
//             "created_at": "2024-0
