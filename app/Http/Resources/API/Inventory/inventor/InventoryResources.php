<?php

namespace App\Http\Resources\API\Inventory\inventor;

use App\Http\Resources\API\Company\CompanyResource;
use App\Http\Resources\API\CompanyUser\UserResource;
use App\Http\Resources\API\Project\ProjectResource;
use App\Http\Resources\API\SubProject\SubProjectResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResources extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $code = '';
        if ($this->invReturnsGoods && $this->invReturnsGoods->first()) {
            $code = $this->invReturnsGoods->first()->return_no;
        } elseif ($this->invInwardGood && $this->invInwardGood->first()) {
            $code = $this->invInwardGood->first()->grn_no;
        } elseif ($this->quotesdetails && $this->quotesdetails->first()) {
            $code = $this->request_no;
        }

        // dd($this->request_no);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'date' => $this->date,
            'code' => $code,
            // 'code' => $this->request_id ?: $this->request_no ?: $this->grn_no ?: $this->issue_no ?: $this->invReturnsGoods->first()->return_no ?: null,
            'details' => $this->details !== null ? $this->details : '',
            'remarks' => $this->remarks !== null ? $this->remarks : '',
            'request_no' => $this->request_no ?: $code ?: '',
            'projects_id' => new  ProjectResource($this->projects),
            'sub_projects_id' => new SubProjectResources($this->subprojects),
            'user_id' => new UserResource($this->users),
            'company_id' => new CompanyResource($this->company),
        ];
    }
}
