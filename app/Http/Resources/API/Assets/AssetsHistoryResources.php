<?php

namespace App\Http\Resources\API\Assets;

use App\Http\Resources\ActivitesResource;
use App\Http\Resources\API\Project\ProjectResource;
use App\Http\Resources\API\Store\StoreResources;
use App\Http\Resources\API\Unit\UnitResources;
use App\Http\Resources\VendorResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// class AssetsHistoryResources extends JsonResource
// {

//     public function toArray($request)
//     {

//         $asset = $this['asset'];
//         $assetHistory = $this['asset_history'] ?? null;
//         $resource = [
//             'asset' => [
//                 'id' => $asset->id,
//                 'uuid' => $asset->uuid,
//                 'name' => $asset->name,
//                 'code' => $asset->code,
//                 'specification' => $asset->specification,
//                 'unit_id' => new UnitResources($asset->units),
//                 'quantity' => $asset->quantity,
//             ]
//         ];

//         if ($assetHistory) {
//             $resource['asset']['history'] = [
//                 'id' => $assetHistory->id,
//                 'uuid' => $assetHistory->uuid,
//                 'qty' => $assetHistory->qty,
//                 'activities_id' => new ActivitesResource($assetHistory->activities),
//                 'vendors_id' => new VendorResources($assetHistory->vendors),
//                 'rate_per_unit' => $assetHistory->rate_per_unit,
//                 'dpr_id' => $assetHistory->dpr_id,
//                 'remarkes' => $assetHistory->remarkes,
//             ];
//         }

//         // $assetsData = [
//         //     'id' => $this->id,
//         //     'uuid' => $this->uuid,
//         //     'name' => $this->name,
//         //     'code' => $this->code,
//         //     'specification' => $this->specification,
//         //     'unit_id' => new UnitResources($this->units),
//         //     'quantity' => $this->quantity,
//         // ];

//         // if ($this->assetsHistory) {
//         //     $history = $this->assetsHistory->first();
//         //     if ($history) {
//         //         $assetsData += [
//         //             'assets_history_id' => $history->id,
//         //             'assets_history_uuid' => $history->uuid,
//         //             'qty' => $history->qty,
//         //             'activities_id' => new ActivitesResource($history->activities),
//         //             'vendors_id' => new VendorResources($history->vendors),
//         //             'rate_per_unit' => $history->rate_per_unit,
//         //             'dpr_id' => $history->dpr_id,
//         //             'remarkes' => $history->remarkes,
//         //         ];
//         //     } else {
//         //         $assetsData += [
//         //             'assets_history_id' => '',
//         //             'assets_history_uuid' => '',
//         //             'qty' => '',
//         //             'activities_id' => '',
//         //             'vendors_id' => '',
//         //             'rate_per_unit' => '',
//         //             'dpr_id' => '',
//         //             'remarkes' => '',
//         //         ];
//         //     }
//         // }

//         return $resource;
//     }
// }


class AssetsHistoryResources extends JsonResource
{

    public function toArray($request)
    {
        $assetsData = [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'code' => $this->code,
            'specification' => $this->specification !== null ? $this->specification : '',
            'unit_id' => new UnitResources($this->units),
            'quantity' => $this->quantity,
        ];
        // dd($this->assetsHistory);

        if ($this->assetsHistory) {
            $history = $this->assetsHistory->first(); // Assuming you only want the first history entry
            if ($history) {
                $assetsData += [
                    'assets_history_id' => $history->id,
                    'assets_history_uuid' => $history->uuid,
                    'qty' => $history->qty ?? 0,
                    'activities_id' => new ActivitesResource($history->activities) ?? [],
                    'vendors_id' => new VendorResource($history->vendors) ?? [],
                    'rate_per_unit' => $history->rate_per_unit ?? 0,
                    'dpr_id' => $history->dpr_id,
                    'remarkes' => $history->remarkes,
                ];
            } else {
                $assetsData += [
                    'assets_history_id' => '',
                    'assets_history_uuid' => '',
                    'qty' => 0,
                    'activities_id' => '',
                    'vendors_id' => '',
                    'rate_per_unit' => 0,
                    'dpr_id' => '',
                    'remarkes' => '',
                ];
            }
        }

        return $assetsData;
    }
}
