<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Admin\AdminMenu;
use App\Models\Admin\AdminUserPermission;
use App\Models\Admin\AdminUserRolePermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserManagmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        checkAdminPermissions('userManagment', auth()->user()->admin_role_id, auth()->user()->id, 'view', true);

        $user_type = $request->user_type;
        $this->setPageTitle('User Management');

        $datas = User::with('role')->where('is_active', 1);
        if ($request->has('search_keyword') && $request->search_keyword != "") {
            $datas = $datas->where(function ($q) use ($request) {
                $q->Where('first_name', 'LIKE', '%' . $request->search_keyword . '%');
                $q->orWhere('email', 'LIKE', '%' . $request->search_keyword . '%');
                $q->orWhere('mobile_number', 'LIKE', '%' . $request->search_keyword . '%');
            })->when($user_type, function ($q) use ($user_type) {
                $q->where('admin_role_id', $user_type);
            });
        }
        $datas = $datas->paginate(10);
        if ($request->ajax()) {
            $datas = $datas->appends($request->all());
            $content = view('Admin.userManagment.include.user-list', compact('datas'))->render();
            return response()->json(['status' => 200, 'content' => $content]);
        }
        return view('Admin.userManagment.index', compact('datas'));
        // endif;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function add(Request $request)
    {
        checkAdminPermissions('userManagment', auth()->user()->admin_role_id, auth()->user()->id, 'view', true);

        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'first_name' => 'required',
                'email' => 'required|unique:users,email',
                'password' => 'required',
                'mobile_number' => 'required',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                //'image'=>'required',
            ]);
            // dd($request->all());
            $fetchId = $request->admin_user_role;
            DB::beginTransaction();
            if ($request->uuid) {
                try {
                    $id = uuidtoid($request->uuid, 'users');
                    // dd($id);
                    // if ($request->hasFile('image')) {
                    //     deleteFile($id, 'users', 'profile_image', 'profile_image');
                    //     $isUpdated = User::where('id', $id)->update([
                    //         'first_name' => $request->first_name,
                    //         'email' => $request->email,
                    //         'password' => Hash::make($request->password),
                    //         'mobile_number' => $request->mobile_number,
                    //         'admin_role_id' => $fetchId,
                    //         'address' => $request->address,
                    //         'state' => $request->city,
                    //         'city' => $request->state,
                    // 'profile_image' => getImgUpload($request->image, 'profile_image'),
                    //     ]);
                    // } else {
                    $isUpdated = User::where('id', $id)->update([
                        'first_name' => $request->first_name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'mobile_number' => $request->mobile_number,
                        'admin_role_id' => $fetchId,
                        'address' => $request->address,
                        'state' => $request->city,
                        'city' => $request->state,
                    ]);
                    // }
                    if ($isUpdated) {
                        DB::commit();
                        // dd($isUpdated);
                        return redirect()->route('admin.userManagment.list')->with('success', 'User Updated Successfully');
                    } else {
                        return redirect()->route('admin.userManagment.list')->with('error', 'something want to be worng');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('admin.userManagment.list')->with('false', $e->getMessage());
                }
            } else {
                try {
                    $imgName = '';
                    $isUserCreated = User::create([
                        'uuid' => Str::uuid(),
                        'first_name' => $request->first_name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'mobile_number' => $request->mobile_number,
                        'admin_role_id' => $fetchId,
                        'address' => $request->address,
                        'state' => $request->city,
                        'city' => $request->state,
                        //  'profile_image' => getImgUpload($request->image, 'profile_image'),
                    ]);

                    $rolePermission = AdminUserRolePermission::where('role_id', $fetchId)->get();
                    $tempArr = [];
                    foreach ($rolePermission as $role) {
                        $tempArr[] = [
                            'user_id' => $isUserCreated->id,
                            'menu_id' => $role->menu_id,
                            'action' => $role->action,
                        ];
                    }
                    //( $tempArr);
                    // dd($isUserCreated );
                    if ($isUserCreated) {
                        AdminUserPermission::insert($tempArr);
                        DB::commit();
                        return redirect()->route('admin.userManagment.list')->with('success', 'User Created Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('admin.userManagment.list')->with('error', $e->getMessage());
                }
            }
        }
        return view('Admin.userManagment.add-user');
    }

    public function userPermission(Request $request, $uuid)
    {
        // dd($uuid);
        checkAdminPermissions('userManagment', auth()->user()->admin_role_id, auth()->user()->id, 'view', true);

        $id = uuidtoid($uuid, 'users');
        $menus = AdminMenu::all();
        $permissionInfo = AdminUserPermission::where('user_id', $id)->get();
        $permissionInfo = $permissionInfo->toArray();
        $tempArr = [];
        if (!empty($permissionInfo)):
            foreach ($permissionInfo as $key => $value):
                $tempArr[$value['menu_id']][] = $value['action'];
            endforeach;
        endif;
        return view('Admin.userManagment.add-userWisePermission', compact('menus', 'tempArr', 'id'));
    }

    public function addUserPermission(Request $request)
    {
        checkAdminPermissions('userManagment', auth()->user()->admin_role_id, auth()->user()->id, 'view', true);

        if ($request->input('updateId')):
            if ($request->input('permission')):
                foreach ($request->input('permission') as $menu => $actions):
                    foreach ($actions as $action):
                        $tempArr[] = [
                            'user_id' => $request->input('updateId'),
                            'menu_id' => $menu,
                            'action' => $action,
                        ];
                    endforeach;
                endforeach;
                $delete = AdminUserPermission::where('user_id', $request->input('updateId'))->delete();
                //    dd($tempArr);
                $insert = AdminUserPermission::insert($tempArr);
                //    dd($insert);
            else:
                $delete = AdminUserPermission::where('user_id', $request->input('updateId'))->delete();
            endif;
        endif;

        // return rediract()->back();
        return redirect()->route('admin.userManagment.list')->with('success', 'User Permission Updated Successfully');
    }

    public function edit(Request $request, $uuid)
    {
        // checkAdminPermissions('userManagment', auth()->user()->admin_role_id, auth()->user()->id, 'view', true);

        $id = uuidtoid($uuid, 'users');
        $data = User::where('id', $id)->first();
        // dd($data);
        if ($data) {
            return view('Admin.userManagment.add-user', compact('data'));
        }
        return redirect()->route('Admin.userManagment.list')->with('error', 'something want to be worng');

    }

}
