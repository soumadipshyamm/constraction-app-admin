<?php

namespace App\Http\Resources\API\Subscription;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResources extends JsonResource
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
            'title' => $this->title,
            'free_subscription' => $this->free_subscription,
            'payment_mode' => $this->payment_mode,
            'amount_inr' => $this->amount_inr ?? 0.00,
            'amount_usd' => $this->amount_usd ?? 0.00,
            'duration' => $this->duration ?? 0.00,
            'trial_period' => $this->trial_period,
            'interval' => $this->interval,
            'subscriptionPackageOption' => SubscriptionAdditionalResources::collection($this->subscriptionPackageOption)
        ];
    }
}
