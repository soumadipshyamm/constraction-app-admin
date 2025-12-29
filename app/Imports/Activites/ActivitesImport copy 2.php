<?php

namespace App\Imports\Activites;

use Illuminate\Support\Str;
use App\Events\ExcelDataImported;
use App\Models\Company\Activities;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ActivitesImportc2 implements ToModel, WithHeadingRow
{
    protected $project;
    protected $subproject;
    protected $companyId;
    protected $tmpcachekey;

    public function __construct($project, $subproject, $companyId, $tmpcachekey)
    {
        $this->project = $project;
        $this->subproject = $subproject;
        $this->companyId = $companyId;
        $this->tmpcachekey = $tmpcachekey;
    }

    public function model(array $row)
    {
        Log::info('Excel import process started', $row);

        // dd(excelDateToDate($row['start_datedd_mm_yyyy']));
        // Null row checking
        if ($this->isNullRow($row)) {
            $this->cacheInvalidRow($row, 'Row is null or contains invalid data');
            return null;
        }

        // dd($row->collection());
        // Validate the row structure
        if (!$this->isValidSlNo($row)) {
            $this->cacheInvalidRow($row);
            return null;
        }

        $companyId = $this->companyId;
        $parentId = $this->calculateParentId($row['sl_no']);

        // Check if the same data already exists
        $existingActivity = Activities::where('project_id', $this->project)
            ->when($this->subproject, function ($query) {
                $query->where('subproject_id', $this->subproject);
            })
            ->where('activities', $row["activities"])   // Assuming 'id' is present in the row
            // ->oRwhere('uuid', $row["uuid"])   // Assuming 'id' is present in the row
            ->where('company_id', $companyId)
            ->first();

        if ($existingActivity) {
            $this->updateExistingActivity($existingActivity, $row);
            return null;
        }

        // Create new activity
        $data = new Activities([
            // 'uuid' => Str::uuid(),
            'project_id' => $this->project,
            'subproject_id' => $this->subproject,
            'type' => $parentId === null ? 'heading' : 'activity',
            'sl_no' => $row['sl_no'],
            'parent_id' => $parentId,
            'activities' => $row['activities'],
            'unit_id' => $this->getUnitId($row['units']),
            'qty' => $row['qty'],
            'rate' => $row['rate'],
            'amount' => $row['qty'] * $row['rate'],
            'start_date' => excelDateToDate($row['start_datedd_mm_yyyy']),
            'end_date' => excelDateToDate($row['end_datedd_mm_yyyy']),
            'company_id' => $companyId,
        ]);
        // dd($data);
        Log::info('************************Excel import process started Activities************************');
        Log::info($data);
        Log::info('************************End Excel import process started Activities************************');
        $this->logExportedData($data);
        return $data;
    }

    protected function isNullRow(array $row)
    {
        // Check if all required fields are null or empty
        $requiredFields = ['type', 'activities'];
        foreach ($requiredFields as $field) {
            if (!isset($row[$field]) || trim($row[$field]) === '') {
                return true;
            }
        }
        return false;
    }

    protected function isValidSlNo(array $row)
    {
        $slNoParts = explode('.', $row['sl_no']);
        $slNoCount = count($slNoParts);

        if ($slNoCount === 1 || $slNoCount === null) {
            return true;
        } elseif ($slNoCount === 2) {
            return $this->checkSlNo($slNoParts[0]);
        } elseif ($slNoCount === 3) {
            $slNoCombined = $slNoParts[0] . '.' . $slNoParts[1];
            return $this->checkSlNo($slNoCombined);
        }

        return false;
    }

    protected function calculateParentId($slNo)
    {
        $slNoParts = explode('.', $slNo);
        $slNoCount = count($slNoParts);

        if ($slNoCount === 1 || $slNoCount === null) {
            return null;
        } elseif ($slNoCount === 2) {
            return $this->getParentId($slNoParts[0]);
        } elseif ($slNoCount === 3) {
            $slNoCombined = $slNoParts[0] . '.' . $slNoParts[1];
            return $this->getParentId($slNoCombined);
        }
        return null;
    }

    protected function getParentId($slNoParts)
    {
        return Activities::where('sl_no', $slNoParts)
            ->where('company_id', $this->companyId)
            ->value('id'); // Directly fetch ID
    }

    protected function checkSlNo($slNoParts)
    {
        return Activities::where('sl_no', $slNoParts)
            ->where('company_id', $this->companyId)
            ->exists(); // Returns true/false
    }

    protected function getUnitId($unitName)
    {
        $unitId = nametoid($unitName, 'units');
        if ($unitId === false) {
            $unitId = createunit($unitName, $this->companyId);
        }
        return $unitId;
    }

    protected function updateExistingActivity($existingActivity, $row)
    {
        $shouldUpdate = (
            $existingActivity->unit_id !== $this->getUnitId($row['units']) ||
            $existingActivity->qty !== $row['qty'] ||
            $existingActivity->rate !== $row['rate'] ||
            $existingActivity->amount !== $row['qty'] * $row['rate']
        );

        // dd($shouldUpdate);
        if ($shouldUpdate) {
            $existingActivity->update([
                'activities' => $row['activities'],
                'unit_id' => $this->getUnitId($row['units']),
                'qty' => $row['qty'],
                'rate' => $row['rate'],
                'amount' => $row['qty'] * $row['rate'],
            ]);
        }
    }

    protected function cacheInvalidRow($row)
    {
        $invalidRows = Cache::get($this->tmpcachekey, []);
        $invalidRows[] = $row;
        Cache::put($this->tmpcachekey, $invalidRows);
    }

    protected function logExportedData($data)
    {
        Log::info('Exported Data:', $data->toArray());
    }
}




// class ActivitesImport implements ToModel, WithHeadingRow
// {
//     protected $project;
//     protected $subproject;
//     protected $companyId;
//     protected $tmpcachekey;

//     public function __construct($project, $subproject, $companyId, $tmpcachekey)
//     {
//         $this->project = $project;
//         $this->subproject = $subproject;
//         $this->companyId = $companyId;
//         $this->tmpcachekey = $tmpcachekey;
//     }

//     public function model(array $row)
//     {
//         Log::info('Excel import process started', $row);
//         // dd($row->collection());
//         // Validate the row structure
//         if (!$this->isValidSlNo($row)) {
//             $this->cacheInvalidRow($row);
//             return null;
//         }

//         $companyId = $this->companyId;
//         $parentId = $this->calculateParentId($row['sl_no']);

//         // Check if the same data already exists
//         $existingActivity = Activities::where('project_id', $this->project)
//             ->when($this->subproject, function ($query) {
//                 $query->where('subproject_id', $this->subproject);
//             })
//             ->where('uuid', $row["uuid"] ?? null) // Assuming 'id' is present in the row
//             ->where('company_id', $companyId)
//             ->first();

//         if ($existingActivity) {
//             $this->updateExistingActivity($existingActivity, $row);
//             return null;
//         }
//             // dd($row);
//         // Create new activity
//         $data = new Activities([
//             'uuid' => Str::uuid(),
//             'project_id' => $this->project,
//             'subproject_id' => $this->subproject,
//             'type' => $parentId === null ? 'heading' : 'activity',
//             'sl_no' => $row['sl_no'],
//             'parent_id' => $parentId,
//             'activities' => $row['activities'],
//             'unit_id' => $this->getUnitId($row['units']),
//             'qty' => $row['qty'],
//             'rate' => $row['rate'],
//             'amount' => $row['qty'] * $row['rate'],
//             'start_date' => $row['start_datedd_mm_yyyy'],
//             'end_date' => $row['end_datedd_mm_yyyy'],
//             'company_id' => $companyId,
//         ]);
//         $this->logExportedData($data);
//         return $data;
//     }

//     protected function isValidSlNo(array $row)
//     {
//         $slNoParts = explode('.', $row['sl_no']);
//         $slNoCount = count($slNoParts);

//         if ($slNoCount === 1 || $slNoCount === null) {
//             return true;
//         } elseif ($slNoCount === 2) {
//             return $this->checkSlNo($slNoParts[0]);
//         } elseif ($slNoCount === 3) {
//             $slNoCombined = $slNoParts[0] . '.' . $slNoParts[1];
//             return $this->checkSlNo($slNoCombined);
//         }
//         return false;
//     }

//     protected function calculateParentId($slNo)
//     {
//         $slNoParts = explode('.', $slNo);
//         $slNoCount = count($slNoParts);

//         if ($slNoCount === 1 || $slNoCount === null) {
//             return null;
//         } elseif ($slNoCount === 2) {
//             return $this->getParentId($slNoParts[0]);
//         } elseif ($slNoCount === 3) {
//             $slNoCombined = $slNoParts[0] . '.' . $slNoParts[1];
//             return $this->getParentId($slNoCombined);
//         }
//         return null;
//     }

//     protected function getParentId($slNoParts)
//     {
//         return Activities::where('sl_no', $slNoParts)
//             ->where('company_id', $this->companyId)
//             ->value('id'); // Directly fetch ID
//     }

//     protected function checkSlNo($slNoParts)
//     {
//         return Activities::where('sl_no', $slNoParts)
//             ->where('company_id', $this->companyId)
//             ->exists(); // Returns true/false
//     }

//     protected function getUnitId($unitName)
//     {
//         $unitId = nametoid($unitName, 'units');

//         if ($unitId === false) {
//             $unitId = createunit($unitName, $this->companyId);
//         }

//         return $unitId;
//     }

//     protected function updateExistingActivity($existingActivity, $row)
//     {
//         $shouldUpdate = (
//             $existingActivity->unit_id !== $this->getUnitId($row['units']) ||
//             $existingActivity->qty !== $row['qty'] ||
//             $existingActivity->rate !== $row['rate'] ||
//             $existingActivity->amount !== $row['qty'] * $row['rate']
//         );

//         if ($shouldUpdate) {
//             $existingActivity->update([
//                 'unit_id' => $this->getUnitId($row['units']),
//                 'qty' => $row['qty'],
//                 'rate' => $row['rate'],
//                 'amount' => $row['qty'] * $row['rate'],
//             ]);
//         }
//     }

//     protected function cacheInvalidRow($row)
//     {
//         $invalidRows = Cache::get($this->tmpcachekey, []);
//         $invalidRows[] = $row;
//         Cache::put($this->tmpcachekey, $invalidRows);
//     }

//     protected function logExportedData($data)
//     {
//         Log::info('Exported Data:', $data->toArray());
//     }
// }
// ***********************************************************************************************************************
