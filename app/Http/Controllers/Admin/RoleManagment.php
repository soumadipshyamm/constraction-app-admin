<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Admin\AdminMenu;
use App\Models\Admin\AdminRole;
use App\Models\Admin\AdminUserRolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleManagment extends BaseController
{
    public function index()
    {
        $this->setPageTitle('Role Management');

        $datas = AdminRole::where('slug', '!=', 'super-admin')->get();
        if (!empty($datas)) {
            return view('Admin.roleManagment.index', compact('datas'));
        }
        return view('Admin.roleManagment.index');
    }
    public function add(Request $request, $id)
    {
        $menus = AdminMenu::all();
        $permissionInfo = AdminUserRolePermission::where('role_id', $id)->get();
        $permissionInfo = $permissionInfo->toArray();
        $tempArr = [];
        if (!empty($permissionInfo)):
            foreach ($permissionInfo as $key => $value):
                $tempArr[$value['menu_id']][] = $value['action'];
            endforeach;
        endif;
        return view('Admin.roleManagment.add-roleWisePermission', compact('menus', 'tempArr', 'id'));
    }
    public function addPermission(Request $request)
    {
        // dd($request->input());
        if ($request->input('permission')):
            foreach ($request->input('permission') as $menu => $actions):
                foreach ($actions as $action):
                    $tempArr[] = [
                        'role_id' => $request->input('updateId'),
                        'menu_id' => $menu,
                        'action' => $action,
                    ];
                endforeach;
            endforeach;
            AdminUserRolePermission::where('role_id', $request->input('updateId'))->delete();
            AdminUserRolePermission::insert($tempArr);
        else:
            AdminUserRolePermission::where('role_id', $request->input('updateId'))->delete();
        endif;
        // return rediract()->back();
        return redirect()->route('admin.roleManagment.list')->with('success', 'Permission Updated Successfully');
    }

    public function addRole(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'role' => 'required',

            ]);
            DB::beginTransaction();
            if ($request->uuid) {
                try {
                    $id = $request->uuid;
                    // dd($id);
                    $isRoleUpdated = AdminRole::where('id', $id)->update([
                        'name' => $request->role,
                    ]);
                    // dd($isClientUpdated);
                    if ($isRoleUpdated) {
                        DB::commit();
                        return redirect()->route('admin.roleManagment.list')->with('success', 'Role Updated Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('admin.roleManagment.list')->with('error', 'something want to be worng');
                }
            } else {
                try {
                    $isRoleCreated = AdminRole::create([
                        'name' => $request->role,
                    ]);
                    // dd($isClientCreated->id);
                    if ($isRoleCreated) {
                        DB::commit();
                        return redirect()->route('admin.roleManagment.list')->with('success', 'Role Created Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    // dd($e->getMessage());
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('admin.roleManagment.list')->with('error', $e->getMessage());
                }
            }
        }
        return view('Admin.roleManagment.add-role');
    }

    public function edit(Request $request, $uuid)
    {
        $id = $uuid;
        $data = AdminRole::where('id', $id)->first();
        // dd($data);
        if ($data) {
            return view('Admin.roleManagment.add-role', compact('data'));
        }
        return redirect()->route('admin.roleManagment.list')->with('error', 'something want to be worng');

    }

}
