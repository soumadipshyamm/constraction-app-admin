<?php

namespace App\Imports\Assets;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Company\Assets;
use App\Models\Company\OpeningStock;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class ImportAssets implements ToModel, WithHeadingRow
{
    protected $project;
    protected $warehouses;

    public function __construct($project, $warehouses)
    {
        $this->project = $project;
        $this->warehouses = $warehouses;
    }

    public function model(array $row)
    {
        // Get the authenticated company ID
        $authCompany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authCompany);

        // Validate if UUID or ID exists in the row for direct updates
        $asset = null;

        if (isset($row['uuid']) && !empty($row['uuid'])) {
            $asset = Assets::where('uuid', $row['uuid'])->first(); // Find by UUID
        } elseif (isset($row['id']) && !empty($row['id'])) {
            $asset = Assets::find($row['id']); // Find by ID
        }

        // Validate the uniqueness of the name for the company
        $existingName = Assets::where('name', $row['assetequipmentsmachinery'])
            ->where('company_id', $companyId)
            ->where(function ($query) use ($asset) {
                if ($asset) {
                    $query->where('id', '!=', $asset->id); // Exclude the current asset if it exists
                }
            })
            ->exists();

        if ($existingName) {
            Log::warning("Duplicate asset name: {$row['assetequipmentsmachinery']} for company ID {$companyId}");
            return null; // Skip this row if the name already exists
        }

        // Update or create the asset
        if ($asset) {
            // Update existing asset
            $asset->update([
                'name' => $row['assetequipmentsmachinery'],
                'specification' => $row['specification'],
                'unit_id' => nametoid($row['unit'], 'units') ?: createunit($row['unit'], $companyId),
            ]);
            Log::info("Updated asset: ", $asset->toArray());
            return $asset;
        } else {
            // Create a new asset
            $newAsset = new Assets([
                'uuid' => Str::uuid(), // Generate UUID for new asset
                'name' => $row['assetequipmentsmachinery'],
                'specification' => $row['specification'],
                'unit_id' => nametoid($row['unit'], 'units') ?: createunit($row['unit'], $companyId),
                'company_id' => $companyId,
            ]);
            Log::info("Created new asset: ", $newAsset->toArray());
            return $newAsset;
        }
    }
}
