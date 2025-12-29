<?php

namespace App\Http\Controllers\Company;

use App\Exports\Vendor\DemoExportVendor;
use App\Exports\Vendor\ExportVendor;
use App\Http\Controllers\BaseController;
use App\Imports\Vendor\VendorImport;
use App\Models\Company\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class VendorController extends BaseController
{
    public function index()
    {
        // domeData(Auth::guard('company')->user()->id);
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $this->setPageTitle('Vendor');
        $datas = Vendor::where('company_id', $companyId)->get();
        if (!empty($datas)) {
            return view('Company.vendor.index', compact('datas'));
        }
        return view('Company.vendor.index');
    }

    public function preview($uuid)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        // $datas = Vendor::all();
        $id = uuidtoid($uuid, 'vendors');
        $datas = Vendor::where('id', $id)->where('company_id', $companyId)->first();
        // dd($datas);
        if (!empty($datas)) {
            return view('Company.vendor.preview', compact('datas'));
        }
    }

    public function add(Request $request)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        if ($request->isMethod('post')) {

            $request->validate([
                'name' => 'required',
                'address' => 'required',
                'type' => 'required|in:supplier,contractor,both',
                'contact_person_name' => 'required',
                'phone' => 'required',
                // 'email' => 'required',
            ]);
            DB::beginTransaction();
            if ($request->uuid) {
                try {
                    $id = uuidtoid($request->uuid, 'vendors');
                    $isProjectUpdated = Vendor::where('id', $id)->update([
                        'name' => $request->name,
                        'gst_no' => $request->gst_no,
                        'address' => $request->address,
                        'type' => $request->type,
                        'contact_person_name' => $request->contact_person_name,
                        'phone' => $request->phone,
                        'email' => $request->email,
                        'additional_fields' => json_encode($request->f),
                    ]);
                    // dd($isClientUpdated);
                    if ($isProjectUpdated) {
                        DB::commit();
                        return redirect()->route('company.vendor.list')->with('success', 'Vendors Updated Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('company.vendor.list')->with('error', 'something want to be worng');
                }
            } else {
                try {
                    $isSubProjectCreated = Vendor::create([
                        'uuid' => Str::uuid(),
                        'name' => $request->name,
                        'gst_no' => $request->gst_no,
                        'address' => $request->address,
                        'type' => $request->type,
                        'contact_person_name' => $request->contact_person_name,
                        'phone' => $request->phone,
                        'email' => $request->email,
                        'company_id' => $companyId,
                        'additional_fields' => json_encode($request->f),
                    ]);
                    // dd($isClientCreated->id);
                    if ($isSubProjectCreated) {
                        DB::commit();
                        return redirect()->route('company.vendor.list')->with('success', 'Vendors Created Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    // dd($e->getMessage());
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('company.vendor.list')->with('error', $e->getMessage());
                }
            }
        }
        return view('Company.vendor.add-edit');
    }
    public function edit(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'vendors');
        $data = Vendor::where('id', $id)->first();
        // dd($data);
        if ($data) {
            return view('Company.vendor.add-edit', compact('data'));
        }
        return redirect()->route('company.vendor.list')->with('error', 'something want to be worng');
    }

    // ****************************************************************************************

    public function bulkbulkupload()
    {
        return view('Company.vendor.bulkupload');
    }

    /**
     * It will return \Illuminate\Support\Collection
     */
    public function export()
    {
        return Excel::download(new ExportVendor(), 'vendors.xlsx');
    }

    /**
     * It will return \Illuminate\Support\Collection
     */
    public function import()
    {
        Excel::import(new VendorImport, request()->file('file'));

        // return back();
        return redirect()->route('company.vendor.list')->with('success', 'Vendors Data Import Successfully');
    }

    public function DemoExportUnit()
    {
        return Excel::download(new DemoExportVendor, 'demo_vendors_export.xlsx');

        return back();
    }
}
