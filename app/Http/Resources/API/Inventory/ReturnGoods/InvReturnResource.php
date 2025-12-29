<?php

namespace App\Http\Resources\API\Inventory\ReturnGoods;

use App\Http\Resources\API\Inventory\IssueInward\IssueTypeResources;
use App\Http\Resources\InvReturnStoreResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvReturnResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd(issueTagFinder($this->tag, $this->inv_issue_lists_id) );
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'inv_returns_id' => $this->inv_returns_id,
            'return_no' => $this->return_no,
            'date' => $this->date,
            'type' => $this->type,
            'inv_issue_lists_id' => new IssueTypeResources($this->invIssueList),
            'tag' => issueTagFinder($this->tag_id, $this->inv_issue_lists_id) ?? '',
            // 'img' => url('/upload/' . $this->img) ?? null,
            // 'tag' => issueTagFinder($this->type, $this->inv_issue_lists_id),
            'remarkes' => $this->remarkes !== null ? $this->remarkes : '',
            'inv_return' => new ReturnListResources($this->whenLoaded('invReturn')),
            'inv_return_details' => InvReturnDetailsResource::collection($this->whenLoaded('invReturnDetails')),
        ];
    }
}
