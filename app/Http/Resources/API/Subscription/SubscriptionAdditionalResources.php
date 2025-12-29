<?php

namespace App\Http\Resources\API\Subscription;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionAdditionalResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'subscription_packages_id' => $this->subscription_packages_id,
            'is_subscription' => $this->is_subscription,
            'paid_subscription' => $this->paid_subscription,
            'subscription_key' => $this->subscription_key,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
