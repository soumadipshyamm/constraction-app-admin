<?php

namespace App\Imports\Test;

use Illuminate\Support\Str;
use App\Models\Company\Labour;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TestImport implements ToModel, WithHeadingRow
{
    private $totalRows = 0;

    public function model(array $row)
    {
        // Get the currently authenticated company's ID
        $companyId = Auth::guard('company')->user()->id;

        // Convert the unit name to an ID or create a new unit if it doesn't exist
        $unitId = nametoid($row['unit'], 'units');
        if (!$unitId) {
            $unitId = createunit($row['unit'], $companyId);
        }

        // Create a new Labour instance
        return new Labour([
            'uuid' => Str::uuid(),
            'name' => $row['name'],
            'category' => $row['category'],
            'unit_id' => $unitId,
            'company_id' => $companyId,
        ]);
    }
    public function getTotalRows()
    {
        return $this->totalRows;
    }

    public function setTotalRows($totalRows)
    {
        $this->totalRows = $totalRows;
    }

    public function startRow(): int
    {
        return 2; // Skip the header row
    }
}
