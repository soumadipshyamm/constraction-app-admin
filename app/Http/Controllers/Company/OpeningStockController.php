<?php

namespace App\Http\Controllers\Company;

use App\Exports\Assets\DemoExportAssets;
use App\Exports\Assets\ExportAssets;
use App\Http\Controllers\BaseController;
use App\Models\Company\OpeningStock;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Exports\MyDataExport;
use App\Exports\Unit\DemoExportUnit;
use App\Imports\Assets\ImportAssets;
use App\Imports\MyDataImport;
use App\Models\Company\Assets;
use App\Models\Company\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class OpeningStockController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('Opening Stock');
        $datas = OpeningStock::with('units')->get();
        if (!empty($datas)) {
            return view('Company.openingStock.index', compact('datas'));
        }
        return view('Company.openingStock.index');
    }

    public function add(Request $request)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        if ($request->isMethod('post')) {
            $request->validate([
                'assets' => 'required',
                'code' => 'required',
                'specification' => 'required',
                'unit_id' => 'required',
                'quantity' => 'required',
            ]);
            DB::beginTransaction();
            if ($request->uuid) {
                try {
                    // dd($request->all());
                    $id = uuidtoid($request->uuid, 'opening_stocks');
                    $isProjectUpdated = OpeningStock::where('id', $id)->update([
                        'assets' => $request->assets,
                        'code' => $request->code,
                        'specification' => $request->specification,
                        'unit_id' => $request->unit_id,
                        'site_usage_unit' => $request->quantity,
                    ]);
                    // dd($isProjectUpdated);
                    if ($isProjectUpdated) {
                        DB::commit();
                        return redirect()->route('company.openingstock.list')->with('success', 'Opening Stock Updated Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('company.openingstock.list')->with('error', 'something want to be worng');
                }
            }
        }
        // return view('Company.assetsAndEquipment.add-edit');
    }

    public function edit(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'opening_stocks');
        $data = OpeningStock::where('id', $id)->first();
        // dd($data);
        if ($data) {
            return view('Company.openingStock.add-edit', compact('data'));
        }
        return redirect()->route('company.openingstock.list')->with('error', 'something want to be worng');
    }
    // *************************************************************************
    public function bulkbulkupload()
    {
        return view('Company.openingStock.bulkupload');
    }
    /**
     * It will return \Illuminate\Support\Collection
     */
    public function export()
    {
        return Excel::download(new ExportAssets, 'assets.xlsx');
    }
    /**
     * It will return \Illuminate\Support\Collection
     */
    public function import()
    {
        // Excel::import(new ImportAssets(), request()->file('file'));
        // return redirect()->route('company.openingstock.list')->with('success', 'Import Data Uploaded Successfully');
    }
    public function DemoExportUnit()
    {
        return Excel::download(new DemoExportAssets, 'demo_assets_export.xlsx');
        return back();
    }
}
