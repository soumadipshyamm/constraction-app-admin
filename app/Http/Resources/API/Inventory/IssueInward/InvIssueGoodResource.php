<?php

namespace App\Http\Resources\API\Inventory\IssueInward;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvIssueGoodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->invIssue );
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'inv_issue' => $this->invIssue ? new IssueListResources($this->invIssue) : '',
            'issue_no' => $this->issue_no,
            'date' => $this->date,
            'type' => $this->type,
            // 'img' =>  url('/upload/' . $this->img),
            'remarkes' => $this->remarkes !== null ? $this->remarkes : '',
            'tag' => issueTagFinder($this->tag_id, $this->inv_issue_lists_id),
            'inv_issue_lists_id' => new IssueTypeResources($this->invIssueList),
            'inv_issue_details' => InvIssueDetailResource::collection($this->whenLoaded('invIssueDetails')),
        ];
    }
}
