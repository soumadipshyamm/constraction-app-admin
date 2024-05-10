<?php

namespace App\Http\Controllers\Company;

use Illuminate\Support\Str;
use App\Models\Company\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UnitsRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class UnitController extends BaseController
{
    public function index()
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);

        $this->setPageTitle('Units');
        $datas = Unit::where('company_id', $companyId)->get();
        if (!empty($datas)) {
            return view('Company.units.index', compact('datas'));
        }
        return view('Company.units.index');
    }
    public function add(Request $request)
    {

        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);

        if ($request->isMethod('post')) {
            // dd($request->all());
            $request->validate([
                'f' => 'required|array',
                'f.*.unit' => 'required',
                'f.*.unit_coversion' => 'sometimes',
                'f.*.unit_coversion_factor' => 'required_with:f.*.unit_coversion|nullable',
            ]);

            DB::beginTransaction();
            if ($request->uuid) {
                try {
                    // dd($request->all());
                    $id = uuidtoid($request->uuid, 'units');
                    // dd($id);
                    foreach ($request->f as $reqValue) {
                        $isProjectUpdated = Unit::where('id', $id)->update([
                            'unit' => $reqValue['unit'],
                            'unit_coversion' => $reqValue['unit_coversion'],
                            'unit_coversion_factor' => $reqValue['unit_coversion_factor'],
                        ]);
                    }
                    // dd($isClientUpdated);
                    if ($isProjectUpdated) {
                        DB::commit();
                        return redirect()->route('company.units.list')->with('success', 'Units Updated Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('company.units.list')->with('error', 'something want to be worng');
                }
            } else {
                try {
                    foreach ($request->f as $reqValue) {
                        $isSubProjectCreated = Unit::create([
                            'uuid' => Str::uuid(),
                            'unit' => $reqValue['unit'],
                            'unit_coversion' => $reqValue['unit_coversion'],
                            'unit_coversion_factor' => $reqValue['unit_coversion_factor'],
                            'company_id' => $companyId
                        ]);
                    }
                    // dd($isClientCreated->id);
                    if ($isSubProjectCreated) {
                        DB::commit();
                        return redirect()->route('company.units.list')->with('success', 'Units  Created Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    // dd($e->getMessage());
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('company.units.list')->with('error', $e->getMessage());
                }
            }
        }

        return view('Company.units.add-edit');
    }
    public function edit(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'units');
        $data = Unit::where('id', $id)->first();
        // dd($data);
        if ($data) {
            return view('Company.units.add-edit', compact('data'));
        }
        return redirect()->route('company.units.list')->with('error', 'something want to be worng');
    }
}
