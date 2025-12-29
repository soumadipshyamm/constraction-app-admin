<?php

namespace App\Http\Controllers\Company;

use App\Exports\Companies\CompaniesExport;
use App\Exports\MyDataExport;
use App\Http\Controllers\BaseController;
use App\Mail\TestMail;
use App\Models\Company\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class CompaniesController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // sendEmail();
       
        Session::put('navbar', 'show');
        $this->setPageTitle('Companies');
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $datas = Companies::where('company_id', $companyId)->where('is_active', 1);
        if ($request->has('search_keyword') && $request->search_keyword != "") {
            $datas = $datas->where(function ($q) use ($request) {
                $q->Where('registration_name', 'LIKE', '%' . $request->search_keyword . '%');
            });
        }
        $datas = $datas->paginate(10);
        if ($request->ajax()) {
            $datas = $datas->appends($request->all());
            // dd($datas);
            return view('Company.companies.include.companies_list', compact('datas'))->render();
            // return response()->json(['status' => 200, 'content' => $content]);
        }
        return view('Company.companies.index', compact('datas'));
    }
    public function add(Request $request)
    {
        Session::put('navbar', 'show');
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'registration_name' => 'required',
                // 'company_registration_no' => 'required',
                // 'registered_address' => 'required',
                // 'logo' => 'mimes:jpg,png,jpeg',
            ]);
            $file = $request->file('img');
            DB::beginTransaction();
            if ($request->uuid) {
                try {
                    $id = uuidtoid($request->uuid, 'companies');
                    if ($request->hasFile('img')) {
                        $isUpdated = Companies::where('id', $id)->update([
                            'registration_name' => $request->registration_name,
                            'company_registration_no' => $request->company_registration_no,
                            'registered_address' => $request->registered_address,
                            'logo' => getImgUpload($file, 'logo'),
                        ]);
                    } else {
                        $isUpdated = Companies::where('id', $id)->update([
                            'registration_name' => $request->registration_name,
                            'company_registration_no' => $request->company_registration_no,
                            'registered_address' => $request->registered_address,
                        ]);
                    }
                    if ($isUpdated) {
                        DB::commit();
                        return redirect()->route('company.companies.list')->with('success', 'Company Updated Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    // dd($e->getMessage());
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('company.companies.list')->with('false', $e->getMessage());
                }
            } else {
                try {
                    $isCompaniesCreated = Companies::create([
                        'uuid' => Str::uuid(),
                        'registration_name' => $request->registration_name,
                        'company_registration_no' => $request->company_registration_no,
                        'registered_address' => $request->registered_address,
                        'logo' => getImgUpload($file, 'logo'),
                        'company_id' => $companyId,
                    ]);
                    if ($isCompaniesCreated) {
                        DB::commit();
                        return redirect()->route('company.companies.list')->with('success', 'Company Created Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('company.companies.list')->with('error', $e->getMessage());
                }
            }
        }
        return view('Company.companies.add-edit');
    }
    public function edit(Request $request, $uuid)
    {
        Session::put('navbar', 'show');
        $id = uuidtoid($uuid, 'companies');
        $data = Companies::where('id', $id)->first();
        // dd($data);
        if ($data) {
            return view('Company.companies.add-edit', compact('data'));
        }
        return redirect()->route('company.companies.list')->with('error', 'something want to be worng');
    }

    public function filter(Request $request, $uuid) {}

    public function export()
    {
        return Excel::download(new CompaniesExport, 'companies.xlsx');
    }
}
