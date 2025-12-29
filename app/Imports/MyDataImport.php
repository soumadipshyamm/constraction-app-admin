<?php
namespace App\Imports;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Company\Labour;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class MyDataImport implements ToModel, WithHeadingRow
{
    /**
     * Import model from the given row.
     *
     * @param  array  $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
{
    $authCompany = Auth::guard('company')->user()->id;
    $companyId = searchCompanyId($authCompany);
    // Get the unit ID from the unit name, or create a new unit if it doesn't exist
    $unitId = nametoid($row['unit'], 'units');
    if (!$unitId) {
        // If the unit doesn't exist, create a new one
        $unitId = createunit($row['unit'], $companyId);
    }
    // dd($unitId);
    // Find existing labour by name, category, and unit (unique constraint)
    $existingLabour = Labour::where('name', $row['name'])       
        ->where('company_id', $companyId)
        ->oRwhere('uuid', $row['uuid'])
        ->first();
        // If a labour exists, update it; otherwise, create a new record
        if ($existingLabour) {
        // dd($existingLabour, $row);
        // Update existing labour
        $existingLabour->update([
            'category' => $row['category'],
            'unit_id' => $unitId,
            'name'=>$row['name']
        ]);
        return $existingLabour; // Return the updated record
    } else {
        // dd($existingLabour);

        // Create new labour record
        return Labour::create([
            'uuid' => Str::uuid(),  // Generate a new UUID for the new record
            'name' => $row['name'],
            'category' => $row['category'],
            'unit_id' => $unitId,
            'company_id' => $companyId,
        ]);
    }
}
    /**
     * After import completes, log the results.
     */
    public function afterImport()
    {
        // Optionally, log the total number of imported records
        Log::info('Import completed at: ' . now());
    }
}
