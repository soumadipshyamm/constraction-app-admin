<?php

namespace App\Http\Resources\API\Inventory\IssueInward;

use App\Http\Resources\API\CompanyUser\UserResource;
use App\Http\Resources\API\Project\ProjectResource;
use App\Http\Resources\API\Store\StoreResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IssueListResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->invIssueGoods->first()->issue_no);
        return [
            "id" => $this->id,
            "uuid" => $this->uuid,
            'code' =>  $this->invIssueGoods->first() ? $this->invIssueGoods->first()->issue_no : null,
            'request_no' =>  $this->invIssueGoods->first() ? $this->invIssueGoods->first()->issue_no : null,
            "name" => $this->name,
            "date" => $this->date,
            "projects_id" => new ProjectResource($this->projects),
            "store_id" =>  StoreResources::collection($this->InvIssueStore),
            "user_id" => new UserResource($this->users),
            // "company_id" => $this->company_id,
        ];
    }
}
// "id": 1,
//             "uuid": "96e3cf7b-aa3c-4ab7-8f1d-28666bce89a0",
//             "name": "2024-03-07",
//             "date": "2024-03-21",
//             "details": null,
//             "remarks": null,
//             "projects_id": 1,
//             "store_id": 1,
//             "user_id": 2,
//             "company_id": 2,
//             "is_active": 1,
//             "created_at": "2024-03-21T08:04:38.000000Z",
