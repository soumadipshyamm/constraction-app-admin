<?php

namespace App\Http\Controllers\Company;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Company\Materials;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\BaseController;
use App\Exports\Materials\MaterialsExport;
use App\Imports\Materials\MaterialsImport;
use App\Models\Company\MaterialIssueStock;
use App\Models\Company\MaterialOpeningStock;
use App\Models\Company\MaterialsStockReport;
use App\Exports\Materials\DemoMaterialsExport;
use App\Exports\Materials\MaterialsIssueExport;
use App\Models\Company\MaterialsStockManagement;
use App\Exports\Materials\MaterialsOpeningStockExport;
use App\Imports\Materials\MaterialsOpeningStockImport;

class MaterialsController extends BaseController
{
    public function index(Request $request)
    {
        Session::put('navbar', 'show');
        $this->setPageTitle('Materials');
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $datas = Materials::with('units')->where('company_id', $companyId)->get();
        $openingMaterials = MaterialOpeningStock::with('materials', 'materials.units', 'projects', 'stores')->where('company_id', $companyId);
        // dd($request->all());
        if ($request->has('project') || $request->has('store')) {
            $openingMaterials = $openingMaterials->where(function ($q) use ($request) {
                $q->Where('project_id', 'LIKE', '%' . $request->project . '%');
                $q->Where('store_id', 'LIKE', '%' . $request->store . '%');
            });
        }
        $openingMaterials = $openingMaterials->get();
        if ($request->ajax()) {
            $openingMaterials = $openingMaterials->appends($request->all());
            // dd($openingMaterials->toArray());
            return view('Company.materials.include.opening-stock-list', compact('openingMaterials'))->render();
            // return response()->json(['status' => 200, 'content' => $content]);
        }
        return view('Company.materials.index', compact('datas', 'openingMaterials'));
    }

    public function add(Request $request)
    {
        Session::put('navbar', 'show');
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $checkAdditionalFeatures = fetchData($companyId, 'materials');
        $isSubscription = checkSubscriptionPermission($companyId, 'material');
        // if (count($checkAdditionalFeatures) < $isSubscription->is_subscription) {
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'class' => 'required|in:A,B,C',
                'name' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $query = Materials::where('name', $value);

                        // Check if specification is null or matches the provided one
                        if ($request->specification) {
                            $query->where('specification', $request->specification);
                        } else {
                            $query->whereNull('specification');
                        }

                        if ($query->exists()) {
                            $fail('A material with the same name and specification already exists.');
                        }
                    },
                ],
                'specification' => 'nullable|string',
                'unit_id' => 'required|exists:units,id', // Ensure unit_id exists in the units table
            ]);
            DB::beginTransaction();
            if ($request->uuid) {
                try {
                    $id = uuidtoid($request->uuid, 'materials');
                    // $materials = Materials::where('id', $id)->first();
                    $isUpdated = Materials::where('id', $id)->update([
                        'class' => $request->class,
                        'name' => $request->name,
                        'specification' => $request->specification,
                        'unit_id' => $request->unit_id,
                    ]);
                    // dd($isCompaniesCreated);
                    if ($isUpdated) {
                        DB::commit();
                        return redirect()->route('company.materials.list')->with('success', 'Materials Updated Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    // dd($e->getMessage());
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('company.materials.list')->with('false', $e->getMessage());
                }
            } else {
                try {
                    // $code = substr(uniqid(), 0, 6);
                    // $fullCode = 'M-' . $code;
                    $ismaterialCreated = Materials::create([
                        'uuid' => Str::uuid(),
                        'class' => $request->class,
                        // 'code' => $fullCode,
                        'name' => $request->name,
                        'specification' => $request->specification,
                        'unit_id' => $request->unit_id,
                        'company_id' => $companyId,
                    ]);
                    if ($ismaterialCreated) {
                        DB::commit();
                        return redirect()->route('company.materials.list')->with('success', 'Materials Created Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('company.materials.list')->with('error', $e->getMessage());
                }
            }
        }
        return view('Company.materials.add-edit');
        // } else {
        //     return redirect()
        //         ->back()
        //         // ->route('company.subscription.list')
        //         ->with('expired', true);
        // }
    }
    public function edit(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'materials');
        $data = Materials::where('id', $id)->first();
        // dd($data);
        if ($data) {
            return view('Company.materials.add-edit', compact('data'));
        }
        return redirect()->route('company.materials.list')->with('error', 'something want to be worng');
    }
    // ********************************Material Excel export/import******************************************************
    public function bulkbulkupload(Request $request)
    {
        return view('Company.materials.bulkupload');
    }
    public function export()
    {
        return Excel::download(new MaterialsExport, 'materials.xlsx');
    }
    public function import(Request $request)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        // $checkAdditionalFeatures = fetchData($companyId, 'materials');
        // $isSubscription = checkSubscriptionPermission($companyId, 'material');
        // if (count($checkAdditionalFeatures) < $isSubscription->is_subscription) {
        $file = $request->file('file');
        Excel::import(new MaterialsImport, $file);
        return redirect()->route('company.materials.list')->with('success', 'Materials Data Import Successfully');
        // } else {
        //     return redirect()
        //         ->back()
        //         // ->route('company.subscription.list')
        //         ->with('expired', true);
        // }
    }
    public function DemoExportUnit()
    {
        return Excel::download(new DemoMaterialsExport, 'demo_materials_export.xlsx');
        return back();
    }
    // *****************************Materials Opening stock****************************************************
    public function stockedit(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'material_opening_stocks');
        $data = MaterialOpeningStock::where('id', $id)->with('materials', 'materials.units', 'projects', 'stores')->first();
        // dd($data);
        if ($data) {
            return view('Company.materials.stock.add-edit', compact('data'));
        }
        return redirect()->route('company.materials.list')->with('error', 'something want to be worng');
    }

    public function addOpeningStock(Request $request)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        DB::beginTransaction();
        if ($request->uuid) {
            try {
                $id = uuidtoid($request->uuid, 'material_opening_stocks');
                $materialsOpeningStock = MaterialOpeningStock::where('id', $id)->first();
                $previewStock = (!empty($materialsOpeningStock->qty) ? $materialsOpeningStock->qty : 0);
                $isCompaniesCreated = MaterialOpeningStock::where('id', $id)->update([

                    'qty' => $request->quantity,
                ]);
                $isCompaniesCreated = MaterialIssueStock::create([
                    'project_id' => $materialsOpeningStock->project_id,
                    'store_id' => $materialsOpeningStock->store_id,
                    'material_id' => $materialsOpeningStock->material_id,
                    'in_stock' => $previewStock,
                    'add_stock' =>  $request->quantity,
                    'less_stock' => $previewStock -  $request->quantity,
                    'total_qty' => '',
                    'code' => '',
                    'type' => 'edit',
                    'action' => 'Manually',
                    'company_id' => $companyId,
                ]);
                if ($isCompaniesCreated) {
                    DB::commit();
                    return redirect()->route('company.materials.list')->with('success', 'Materials Created Successfully');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                return redirect()->route('company.materials.list')->with('error', $e->getMessage());
            }
        }
    }
    // *****************************Materials Opening stock Excel export/import**********************************************************
    public function exportOpeningStock()
    {
        return Excel::download(new MaterialsOpeningStockExport, 'materials_opeinig_stock.xlsx');
    }
    public function importOpeningStock(Request $request)
    {
        // dd($request->all());
        // try {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $file = $request->file('file');
        $project = $request->project;
        $warehouses = $request->warehouses;
        $openingStockDate = $request->opeing_stock_date;
        // dd($request->all());
        $datatImport = Excel::import(new MaterialsOpeningStockImport($project, $warehouses, $openingStockDate, $companyId), $file);
        // dd($datatImport);
        return redirect()->route('company.materials.list')->with('success', 'Import Data Uploaded Successfully');
        // } catch (\Exception $e) {
        //     // Log the error message
        //     Log::error('Error importing Excel file: ' . $e->getMessage());
        //     return redirect()->back()->with('error', 'Error importing Excel file');
        // }
    }
    // *********************************Material Opening Stock Report******************************************************
    public function stockhistory(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'materials');
        $datas = MaterialsStockReport::where('material_id', $id)->with('materials')->get();
        // dd($data);
        if ($datas) {
            return view('Company.materials.stock-history', compact('datas'));
        }
    }
    // ********************************************************************************************************
    public function issuestockedit($uuid)
    {
        return view('Company.materials.issue.add-edit');
    }
}
