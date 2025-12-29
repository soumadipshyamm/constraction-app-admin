<?php

namespace App\Http\Resources\API\Company;

use App\Http\Resources\API\Subscription\SubscriptionResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $type = isSubscribedFree() ?  'free' : 'paid';
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'registration_no' => $this->registration_no,
            'address' => $this->address,
            'country_code' => $this->country_code,
            'phone' => $this->phone,
            'website_link' => $this->website_link,
            'is_subscribed' => $this->is_subscribed != null ? true : false,
            'subscribed_type' =>  $type,
            'subscribed' => new SubscriptionResources($this->subscription)
        ];
    }
}
