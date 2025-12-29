<?php

namespace App\Http\Controllers\Company;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Company\Teams;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;

class TeamsController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $this->setPageTitle('Teams');
        $datas = Teams::with('profileRole')->where('company_id', $companyId)->get();
        // dd($datas);
        if (!empty($datas)) {
            return view('Company.teams.index', compact('datas'));
        }
        return view('Company.teams.index');
    }

    public function add(Request $request)
    {
        // dd($request->all());
        if ($request->isMethod('post')) {

            $request->validate([
                'name' => 'required',
                // 'designation' => 'required',
                // 'aadhar_no' => 'required',
                // 'pan_no' => 'required',
                // 'email' => 'required',
                // 'phone' => 'required',
                // 'address' => 'required',
                // 'profile_role' => 'required',
            ]);
            // dd($request->all());
            DB::beginTransaction();
            // if ($request->uuid) {
            //     try {
            //         $id = uuidtoid($request->uuid, 'teams');
            //         $isProjectUpdated = Teams::where('id', $id)->update([
            //             'user_id' => auth()->user()->id,
            //             'name' => $request->name,
            //             'designation' => $request->designation,
            //             'aadhar_no' => $request->aadhar_no,
            //             'pan_no' => $request->pan_no,
            //             'email' => $request->email,
            //             'phone' => $request->phone,
            //             'address' => $request->address,
            //             'profile_role' => $request->profile_role,
            //             'reporting_person' => $request->reporting_person ,
            //         ]);
            //         // dd($isClientUpdated);
            //         if ($isProjectUpdated) {
            //             DB::commit();
            //             return redirect()->route('company.teams.list')->with('success', 'Teams Updated Successfully');
            //         }
            //     } catch (\Exception $e) {
            //         DB::rollBack();
            //         logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
            //         return redirect()->route('company.teams.list')->with('error', 'something want to be worng');
            //     }
            // } else {
            try {
                $isSubProjectCreated = Teams::create([
                    'uuid' => Str::uuid(),
                    'name' => $request->name ?? null,
                    'designation' => $request->designation ?? null,
                    'aadhar_no' => $request->aadhar_no ?? null,
                    'pan_no' => $request->pan_no ?? null,
                    'email' => $request->email ?? null,
                    'phone' => $request->phone ?? null,
                    'address' => $request->address ?? null,
                    'profile_role' => $request->profile_role ?? null,
                    'reporting_person' => $request->reporting_person ?? null,
                ]);
                // dd($isClientCreated->id);
                if ($isSubProjectCreated) {
                    DB::commit();
                    return redirect()->route('company.teams.list')->with('success', 'Teams Created Successfully');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                // dd($e->getMessage());
                logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                return redirect()->route('company.teams.list')->with('error', $e->getMessage());
            }
            // }
        }
        return view('Company.teams.add-edit');
    }
    public function edit(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'teams');
        $data = Teams::where('id', $id)->first();
        // dd($data);
        if ($data) {
            return view('Company.teams.add-edit', compact('data'));
        }
        return redirect()->route('company.teams.list')->with('error', 'something want to be worng');
    }
}
