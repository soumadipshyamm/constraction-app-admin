<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Company\Company_role;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Models\Company\Company_permission;
use App\Models\Company\Company_role_permission;

class CompanyRoleManagmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $this->setPageTitle('Roles');
        $companyIds = [0, $companyId];
        $datas = Company_role::whereIn('company_id', $companyIds)->get();
        if (!empty($datas)) {
            return view('Company.roleManagment.index', compact('datas'));
        }
        return view('Company.roleManagment.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addRole(Request $request)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);

        if ($request->isMethod('post')) {
            $request->validate([
                'role' => 'required|unique:company_roles,slug,NULL,id,company_id,' . $companyId,
            ]);
            DB::beginTransaction();
            if ($request->uuid) {
                try {
                    $id = $request->uuid;
                    // dd($id);
                    $isRoleUpdated = Company_role::where('id', $id)->update([
                        'name' => $request->role,
                    ]);
                    // dd($isClientUpdated);
                    if ($isRoleUpdated) {
                        DB::commit();
                        return redirect()->route('company.roleManagment.list')->with('success', 'Role Updated Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('company.roleManagment.list')->with('error', 'something want to be worng');
                }
            } else {
                try {
                    //    dd( $request->all());
                    // dd(createSlug($request->role));
                    $isRoleCreated = Company_role::create([
                        'name' => $request->role,
                        'slug' => createSlug($request->role),
                        'company_id' => $companyId
                    ]);
                    // dd($isClientCreated);
                    if ($isRoleCreated) {
                        DB::commit();
                        return redirect()->route('company.roleManagment.list')->with('success', 'Role Created Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    // dd($e->getMessage());
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('company.roleManagment.list')->with('error', $e->getMessage());
                }
            }
        }
        return view('Company.roleManagment.add-role');
    }

    public function edit(Request $request, $uuid)
    {
        $id = $uuid;
        $data = Company_role::where('id', $id)->first();
        // dd($data);
        if ($data) {
            return view('Company.roleManagment.add-role', compact('data'));
        }
        return redirect()->route('company.roleManagment.list')->with('error', 'something want to be worng');
    }

    public function companyUserpermission(Request $request, $id)
    {
        $menus = Company_permission::all();
        $permissionInfo = Company_role_permission::where('company_role_id', $id)->get();
        $permissionInfo = $permissionInfo->toArray();
        $tempArr = [];
        if (!empty($permissionInfo)) :
            foreach ($permissionInfo as $key => $value) :
                $tempArr[$value['company_permission_id']][] = $value['action'];
            endforeach;
        endif;
        return view('Company.roleManagment.add-roleWisePermission', compact('menus', 'tempArr', 'id'));
    }

    public function addPermission(Request $request)
    {
        $inputPermissions = $request->input('permission');

        // dd($inputPermissions);
        if ($inputPermissions) {
            $tempArr = [];
            foreach ($inputPermissions as $menu => $actions) {
                foreach ($actions as $action) {
                    $tempArr[] = [
                        'company_role_id' => $request->input('updateId'),
                        'company_permission_id' => $menu,
                        'action' => $action,
                    ];
                }
            }

            Company_role_permission::where('company_role_id', $request->input('updateId'))->delete();
            Company_role_permission::insert($tempArr);
        } else {
            Company_role_permission::where('company_role_id', $request->input('updateId'))->delete();
        }
        return redirect()->back()->with('success', 'Role permissions updated successfully.');
    }
}
