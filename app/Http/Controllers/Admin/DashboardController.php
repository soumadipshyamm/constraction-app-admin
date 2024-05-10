<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //    $admin = AdminUserPermission::with('menu')->get();
        //    return $admin;
        // if (checkAdminPermissions('dashboard', auth()->user()->admin_role_id, auth()->user()->id, 'view', true)) {
            return view('Admin.dashboard.index');
        // } else {
        //     return redirect()->route('admin.profile');
        // }
    }

    public function UpdatePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            // dd($request->all());
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|different_from_old_password:old_password',
                // 'new_password' => 'required',
                'confirm_password' => ['same:new_password'],
            ]);
            DB::beginTransaction();
            try {
                if (Hash::check($request->old_password, auth()->user()->password)) {
                    $passwordUpdate = User::find(auth()->user()->id)->update([
                        'password' => Hash::make($request->new_password),
                    ]);
                    // dd($passwordUpdate);
                    DB::commit();
                    return redirect()->route('admin.home')->with('success', 'Password Updated Successfully');
                } else {
                    // return $this->responseRedirectBack('do not matched the password ', 'info', true, true);
                    return redirect()->route('admin.dashboard.password-update')->with('error', 'Do not matched the password');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('admin.dashboard.password-update')->with('error', 'something want to be worng');
            }
        }
        return view('Admin.dashboard.password-update');
    }

    public function profile(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'first_name' => 'required',
                'address' => 'required',
                'mobile_number' => 'required',
                'profile_image' => 'mimes:jpg,png,jpeg',
            ]);

            DB::beginTransaction();
            if ($request->uuid) {
                try {
                    $id = uuidtoid($request->uuid, 'users');
                    if ($request->hasFile('profile_image')) {
                        // deleteFile($id, 'home_pages', 'profile_image', 'profile_image');
                        $isProfileUpdated = User::where('id', $id)->update([
                            'first_name' => $request->first_name,
                            'address' => $request->address,
                            'mobile_number' => $request->mobile_number,
                            'profile_image' => getImgUpload($request->profile_image, 'profile_image'),
                        ]);
                    } else {
                        $isProfileUpdated = User::where('id', $id)->update([
                            'first_name' => $request->first_name,
                            'address' => $request->address,
                            'mobile_number' => $request->mobile_number,
                        ]);
                    }
                    if ($isProfileUpdated) {
                        DB::commit();
                        return redirect()->route('admin.profile')->with('success', 'Profile Updated Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('admin.profile')->with('error', 'something want to be worng');
                }
            }
        }
        $id = auth()->user()->id;
        $data = User::select('uuid', 'first_name', 'email', 'address', 'mobile_number', 'profile_image')->where('id', $id)->first();
        return view('Admin.profile.index', compact('data'));
    }
}
