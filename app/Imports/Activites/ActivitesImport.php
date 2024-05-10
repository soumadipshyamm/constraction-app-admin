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

class ActivitesImport implements ToModel, WithHeadingRow
{
    protected $project;
    protected $subproject;
    protected $companyId;
    protected $tmpcachekey;
    public function __construct($project, $subproject, $companyId, $tmpcachekey)
    {
        $this->project = $project;
        $this->subproject = $subproject;
        $this->companyId =  $companyId;
        $this->tmpcachekey =  $tmpcachekey;
    }
    public function model(array $row)
    {
        // Log::channel('excel')->info('Imported row: ' . json_encode($row));
        // dd($row['activities']);
        Log::info('Excel import successful', $row);
        $companyId = $this->companyId;
        // if ($this->isValidRow($row)) {
        // dd($row);
        if ($this->isValidSlNo($row, $companyId)) {
            $parentId = $this->calculateParentId($row['sl_no'], $companyId);
            $data = new Activities([
                'uuid' => Str::uuid(),
                'project_id' => $this->project,
                'subproject_id' => $this->subproject,
                'type' => $parentId === null ? 'heading' : 'activites',
                'sl_no' => $row['sl_no'],
                'parent_id' => $parentId,
                'activities' => $row['activities'],
                'unit_id' => $this->getUnitId($row['unit_id'], $companyId),
                'qty' => $row['qty'],
                'rate' => $row['rate'],
                'amount' => $row['qty'] * $row['rate'],
                'start_date' => $row['start_date'],
                'end_date' => $row['end_date'],
                'company_id' => $companyId,
            ]);
            return $data;
        } else {
            // dd($row);
            $arr = Cache::get($this->tmpcachekey, []); // Get the cached array or initialize an empty array if it doesn't exist
            $arr[] = $row; // Push the value onto the array
            // dd($row);
            // Put the updated array back in the cache
            Cache::put($this->tmpcachekey, $arr);
        }
        // }
    }
    // *********************************************************************************
    // protected function isValidRow(array $row)
    // {
    //     dd($row);
    //     return in_array($row['heading'], ['activites']);
    // }
    protected function isValidSlNo(array $row, $companyId)
    {
        $slNoParts = explode('.', $row['sl_no']);
        $slNoCount = count($slNoParts);
        // dd($slNoParts);
        if ($slNoCount === 1 || $slNoCount === null) {
            // dd($row);
            $isvalid = true;
        } elseif ($slNoCount === 2) {
            $isvalid = $this->getCheckSlNo($slNoParts[0], $companyId);
            // $this->importLog($isvalid, $row);
        } elseif ($slNoCount === 3) {
            $slNoCombined = $slNoParts[0] . '.' . $slNoParts[1];
            $isvalid = $this->getCheckSlNo($slNoCombined, $companyId);
            // $this->importLog($isvalid, $row);
        }
        // dd($isvalid);
        // $this->importLog($isvalid, $row);
        return $isvalid;
    }
    protected function importLog($isvalid, $row)
    {
        if ($isvalid == false) {
            Log::channel('excel')->info('Imported row: ' . json_encode($row));
        }
    }
    protected function calculateParentId($slNo, $companyId)
    {
        $slNoParts = explode('.', $slNo);
        $slNoCount = count($slNoParts);
        if ($slNoCount === 1 || $slNoCount === null) {
            return null;
        } elseif ($slNoCount === 2) {
            return $this->getCheckParentId($slNoParts[0], $companyId);
        } elseif ($slNoCount === 3) {
            $slNoCombined = $slNoParts[0] . '.' . $slNoParts[1];
            return $this->getCheckParentId($slNoCombined, $companyId);
        }
        return null;
    }
    protected function getCheckParentId($slNoParts, $companyId)
    {
        $data = Activities::where('sl_no', $slNoParts)->where('company_id', $companyId)->orderBy('id', 'DESC')->first();
        if ($data == null) {
            return null;
        }
        return $data->id;
    }
    protected function getCheckSlNo($slNoParts, $companyId)
    {
        $data = Activities::where('sl_no', $slNoParts)->where('company_id', $companyId)->orderBy('id', 'DESC')->first();
        if ($data == null) {
            return false;
        }
        return $data->id;
    }
    protected function getUnitId($unitName, $companyId)
    {
        $unitId = nametoid($unitName, 'units');
        if ($unitId === false) {
            $unitId = createunit($unitName, $companyId);
        }
        return $unitId;
    }
}
// ***********************************************************************************************************************
