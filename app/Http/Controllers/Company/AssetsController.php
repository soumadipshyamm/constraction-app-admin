<?php

namespace App\Http\Controllers\Company;

use App\Traits\FlashMessages;
use Illuminate\Support\Str;
use App\Models\Company\Unit;
use Illuminate\Http\Request;
use App\Exports\MyDataExport;
use App\Imports\MyDataImport;
use App\Models\Company\Assets;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exports\Assets\ExportAssets;
use App\Exports\Unit\DemoExportUnit;
use App\Imports\Assets\ImportAssets;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\BaseController;
use App\Models\Assets\AssetsOpeningStock;
use App\Exports\Assets\ExportAssesOpeningStock;
use App\Imports\Assets\ImportAssesOpeningStock;

class AssetsController extends BaseController
{
    // use FlashMessages;
    public function index(Request $request)
    {
        // dd($request->all());
        Session::put('navbar', 'show');
        $this->setPageTitle('Assets');
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $datas = Assets::with('units', 'project', 'store_warehouses')
            ->where('company_id', $companyId)
            ->get();
        $openingAsstes = AssetsOpeningStock::with('assets', 'assets.units', 'projects', 'stores')->where('company_id', $companyId);
        if ($request->has('project') || $request->has('store')) {
            $openingAsstes = $openingAsstes->where(function ($q) use ($request) {
                $q->Where('project_id', 'LIKE', '%' . $request->project . '%');
                $q->Where('store_id', 'LIKE', '%' . $request->store . '%');
            });
        }
        $openingAsstes = $openingAsstes->paginate(10);
        if ($request->ajax()) {
            $openingAsstes = $openingAsstes->appends($request->all());
            return view('Company.assetsAndEquipment.include.opening-stock-list', compact('openingAsstes'))->render();
        }
        return view('Company.assetsAndEquipment.index', compact('datas', 'openingAsstes'));
    }
    public function add(Request $request)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $checkAdditionalFeatures = fetchData($companyId, 'assets');
        $isSubscription = checkSubscriptionPermission($companyId, 'material');
        // dd($isSubscription);
        if (count($checkAdditionalFeatures) < $isSubscription->is_subscription) {
            if ($request->isMethod('post')) {
                // dd($isSubscription);
                // dd(count($checkAdditionalFeatures));
                $request->validate([
                    // 'project' => 'required',
                    // 'ware_house' => 'required',
                    'name' => 'required',
                    // 'code' => 'required|unique:assets,code',
                    'specification' => 'required',
                    'unit_id' => 'required',
                    // 'quantity' => 'required',
                ]);
                DB::beginTransaction();
                if ($request->uuid) {
                    try {
                        $id = uuidtoid($request->uuid, 'assets');
                        $isProjectUpdated = Assets::where('id', $id)->update([
                            'name' => $request->name,
                            // 'project_id' => $request->project,
                            // 'store_warehouses_id' => $request->ware_house,
                            // 'code' => $request->code,
                            'specification' => $request->specification,
                            'unit_id' => $request->unit_id,
                            // 'quantity' => $request->quantity,
                        ]);
                        // dd($isClientUpdated);
                        if ($isProjectUpdated) {
                            DB::commit();
                            return redirect()
                                ->route('company.assets.list')
                                ->with('success', 'Units Updated Successfully');
                        }
                    } catch (\Exception $e) {
                        DB::rollBack();
                        logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                        return redirect()
                            ->route('company.assets.list')
                            ->with('error', 'something want to be worng');
                    }
                } else {
                    try {
                        $isSubProjectCreated = Assets::create([
                            'uuid' => Str::uuid(),
                            // 'project_id' => $request->project,
                            // 'store_warehouses_id' => $request->ware_house,
                            'name' => $request->name,
                            'code' => uniqid(6),
                            'specification' => $request->specification,
                            'unit_id' => $request->unit_id,
                            // 'quantity' => $request->quantity,
                            'company_id' => $companyId,
                        ]);
                        // dd($isClientCreated->id);
                        if ($isSubProjectCreated) {
                            DB::commit();
                            return redirect()
                                ->route('company.assets.list')
                                ->with('success', 'Units  Created Successfully');
                        }
                    } catch (\Exception $e) {
                        DB::rollBack();
                        // dd($e->getMessage());
                        logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                        return redirect()
                            ->route('company.assets.list')
                            ->with('error', $e->getMessage());
                    }
                }
            }
            return view('Company.assetsAndEquipment.add-edit');
        } else {
            return redirect()
                ->back()
                // ->route('company.subscription.list')
                ->with('expired', true);
        }
    }
    public function edit(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'assets');
        $data = Assets::where('id', $id)->first();
        // dd($data);
        if ($data) {
            return view('Company.assetsAndEquipment.add-edit', compact('data'));
        }
        return redirect()
            ->route('company.assets.list')
            ->with('error', 'something want to be worng');
    }

    // ***********************************************************************************

    public function bulkbulkupload()
    {
        return view('Company.assetsAndEquipment.bulkupload');
    }

    public function export()
    {
        return Excel::download(new ExportAssets(), 'assetsAndEquipment.xlsx');
    }

    public function import(Request $request)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $checkAdditionalFeatures = fetchData($companyId, 'assets');
        $isSubscription = checkSubscriptionPermission($companyId, 'material');
        // dd($isSubscription);
        if (count($checkAdditionalFeatures) < $isSubscription->is_subscription) {
            $file = $request->file('file');
            $project = $request->project;
            $warehouses = $request->warehouses;

            Excel::import(new ImportAssets($project, $warehouses), $file);

            return redirect()
                ->route('company.assets.list')
                ->with('success', 'Import Data Uploaded Successfully');
        } else {
            return redirect()
                ->back()
                // ->route('company.subscription.list')
                ->with('expired', true);
        }
    }

    public function DemoExportUnit()
    {
        return Excel::download(new ExportAssets(), 'assetsAndEquipment.xlsx');

        return back();
    }

    // ************************************************************************************************
    public function exportOpeningStock()
    {
        return Excel::download(new ExportAssesOpeningStock(), 'asstes_opeinig_stock.xlsx');
    }

    public function importOpeningStock(Request $request)
    {
        try {
            $authConpany = Auth::guard('company')->user()->id;
            $companyId = searchCompanyId($authConpany);
            $file = $request->file('file');
            $project = $request->project;
            $warehouses = $request->warehouses;
            $openingStockDate = $request->opeing_stock_date;
            // dd($request->all());
            $datatImport = Excel::import(new ImportAssesOpeningStock($project, $warehouses, $openingStockDate, $companyId), $file);
            // dd($datatImport);
            return redirect()
                ->route('company.assets.list')
                ->with('success', 'Import Data Uploaded Successfully');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error importing Excel file: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Error importing Excel file');
        }
    }
    // *********************************Assets Opening Stock Report******************************************************

    public function stockhistory(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'materials');
        $datas = AssetsOpeningStock::where('material_id', $id)
            ->with('materials')
            ->get();
        // dd($data);
        if ($datas) {
            return view('Company.materials.stock-history', compact('datas'));
        }
    }
}
