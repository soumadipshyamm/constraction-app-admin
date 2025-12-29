<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\BaseController;
use App\Models\Company\profileDesignation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProfileDesignationController extends BaseController
{
    public function index()
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);

        $this->setPageTitle('Profile Designation');
        $datas = profileDesignation::where('company_id', $companyId)->get();
        if (!empty($datas)) {
            return view('Company.profileDesignation.index', compact('datas'));
        }
        return view('Company.profileDesignation.index');
    }
    public function add(Request $request)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        if ($request->isMethod('post')) {
            //dd($request->all());
            $request->validate([
                'name' => 'required',
            ]);
            DB::beginTransaction();

            if ($request->uuid) {
                try {
                    $id = uuidtoid($request->uuid, 'profile_designations');
                    // dd($id);
                    $isprofileDesignationUpdated = profileDesignation::where('id', $id)->update([
                        'name' => $request->name,
                    ]);
                    // dd($isClientUpdated);
                    if ($isprofileDesignationUpdated) {
                        DB::commit();
                        return redirect()
                            ->route('company.profileDesignation.list')
                            ->with('success', 'Profile Designation Updated Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()
                        ->route('company.profileDesignation.list')
                        ->with('error', 'something want to be worng');
                }
            } else {
                try {
                    $isprofileDesignationCreated = profileDesignation::create([
                        'uuid' => Str::uuid(),
                        'name' => $request->name,
                        'company_id' => $companyId,
                    ]);

                    //dd($isClientCreated->id);
                    if ($isprofileDesignationCreated) {
                        DB::commit();
                        return redirect()
                            ->route('company.profileDesignation.list')
                            ->with('success', 'Profile Designation Created Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    // dd($e->getMessage());
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()
                        ->route('company.profileDesignation.list')
                        ->with('error', $e->getMessage());
                }
            }
        }
        return view('Company.profileDesignation.add-edit');
    }
    public function edit(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'profile_designations');
        $data = profileDesignation::where('id', $id)->first();
        // dd($data->client);
        if ($data) {
            return view('Company.profileDesignation.add-edit', compact('data'));
        }
        return $this->responseJson(false, 200, 'No data found');
    }
}