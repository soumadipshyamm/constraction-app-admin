<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\BaseController;
use App\Models\Company\Labour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Exports\MyDataExport;
use App\Exports\Unit\DemoExportUnit;
use App\Imports\MyDataImport;
use App\Models\Company\Unit;
use Maatwebsite\Excel\Facades\Excel;

class LabourController extends BaseController
{
    public function index()
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);

        $this->setPageTitle('Units');
        $datas = Labour::with('units')->where('company_id', $companyId)->get();
        if (!empty($datas)) {
            return view('Company.labour.index', compact('datas'));
        }
        return view('Company.labour.index');
    }

    public function add(Request $request)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);

        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required',
                'category' => 'required|in:skilled,semiskilled,unskilled',
                'unit_id' => 'required',
            ]);
            // dd($request->all());
            // DB::beginTransaction();
            if ($request->uuid) {
                // try {
                    $id = uuidtoid($request->uuid, 'labours');
                    // dd($id);
                    $isProjectUpdated = Labour::where('id', $id)->update([
                        'name' => $request->name,
                        'category' => $request->category,
                        'unit_id' => $request->unit_id,
                    ]);
                    // dd($isClientUpdated);
                    if ($isProjectUpdated) {
                        DB::commit();
                        return redirect()->route('company.labour.list')->with('success', 'Units Updated Successfully');
                    }
                // } catch (\Exception $e) {
                //     DB::rollBack();
                //     logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                //     return redirect()->route('company.labour.list')->with('error', 'something want to be worng');
                // }
            } else {
                // try {
                    $isLabourCreated = Labour::create([
                        // 'uuid' => Str::uuid(),
                        'name' => $request->name,
                        'category' => $request->category,
                        'unit_id' => $request->unit_id,
                        'company_id' => $companyId,
                    ]);
                    // dd($isClientCreated->id);
                    // dd($isLabourCreated);
                    if ($isLabourCreated) {
                        // DB::commit();
                        return redirect()->route('company.labour.list')->with('success', 'Units  Created Successfully');
                    }
                // } catch (\Exception $e) {
                //     DB::rollBack();
                //     // dd($e->getMessage());
                //     logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                //     return redirect()->route('company.labour.list')->with('error', $e->getMessage());
                // }
            }
        }
        return view('Company.labour.add-edit');
    }

    public function edit(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'labours');
        $data = Labour::where('id', $id)->first();
        // dd($data);
        if ($data) {
            return view('Company.labour.add-edit', compact('data'));
        }
        return redirect()->route('company.labour.list')->with('error', 'something want to be worng');
    }

    // **************************************************************************************
    public function bulkbulkupload()
    {
        return view('Company.labour.bulkupload');
    }

    /**
     * It will return \Illuminate\Support\Collection
     */
    public function export()
    {
        return Excel::download(new MyDataExport, 'labour.xlsx');
    }

    /**
     * It will return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:10240', // 10MB max file size
        ]);

        // Check if a file is uploaded
        if ($request->hasFile('file')) {
            try {
                // Get the uploaded file from the request
                $file = $request->file('file');

                // Import the file data using the MyDataImport class
                Excel::import(new MyDataImport, $file);

                // Return success message upon successful import
                return redirect()->route('company.labour.list')->with('success', 'Data Imported Successfully!');
            } catch (\Exception $e) {
                // In case of any error during the import, return with an error message
                return redirect()->route('company.labour.list')->with('error', 'Error during import: ' . $e->getMessage());
            }
        }

        // If no file is selected or there's an issue with the file
        return back()->with('error', 'No file selected for import or invalid file type.');
    }


        //     $authConpany = Auth::guard('company')->user()->id;
        //     $companyId = searchCompanyId($authConpany);
        //     $checkAdditionalFeatures = fetchData($companyId, 'assets');
        //     $isSubscription = checkSubscriptionPermission($companyId, 'material');
        //     // dd($isSubscription);
        //     if (count($checkAdditionalFeatures) < $isSubscription->is_subscription) {
            // Added error handling for file import
            // try {
            // $file = $request->file('file');
            // Excel::import(new MyDataImport, $file);
            // return redirect()
            //     ->route('company.labour.list')
            //     ->with('success', 'Import Data Uploaded Successfully');
        // } catch (\Exception $e) {
        //     // Log the error and redirect with an error message
        //     logger($e->getMessage());
        //     return redirect()
        //         ->route('company.labour.list')
        //         ->with('error', 'Failed to import data. Please try again.');
        // }
        // } else {
        //     return redirect()
        //         ->back()
        //         // ->route('company.subscription.list')
        //         ->with('expired', true);
        // }
    // }

    public function DemoExportUnit()
    {
        return Excel::download(new DemoExportUnit, 'demo_unit_export.xlsx');

        return back();
    }
}
