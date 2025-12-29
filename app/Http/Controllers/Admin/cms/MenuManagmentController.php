<?php

namespace App\Http\Controllers\Admin\cms;

use App\Http\Controllers\BaseController;
use App\Models\Admin\Cms\MenuManagment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuManagmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->setPageTitle('Menu Managment');
        $datas = MenuManagment::all();
        if (!empty($datas)) {
            return view('Admin.cms.menuManagment.index', compact('datas'));
        }
        return view('Admin.cms.menuManagment.index');
    }
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'menu_position' => 'required',
                'menu_label' => 'required',
                'link_type' => 'required',
                'block_list' => 'required',
            ]);
            DB::beginTransaction();
            if ($request->uuid) {
                try {
                    $id = uuidtoid($request->uuid, 'menu_managments');
                    $isUpdated = MenuManagment::where('id', $id)->update([
                        'position' => $request->menu_position,
                        'lable' => $request->menu_label,
                        'type' => $request->link_type,
                        'site_page' => $request->block_list,
                    ]);
                    if ($isUpdated) {
                        DB::commit();
                        return redirect()->route('admin.menuManagment.list')->with('success', 'Company Managment Updated Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('admin.menuManagment.list')->with('false', $e->getMessage());
                }
            } else {
                try {
                    $isMenuCreated = MenuManagment::create([
                        'position' => $request->menu_position,
                        'lable' => $request->menu_label,
                        'type' => $request->link_type,
                        'site_page' => $request->block_list,
                    ]);

                    if ($isMenuCreated) {
                        DB::commit();
                        return redirect()->route('admin.menuManagment.list')->with('success', 'Company Managment Created Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('admin.menuManagment.list')->with('error', $e->getMessage());
                }
            }
        }
        return view('Admin.cms.menuManagment.add-edit');
    }
    public function edit($uuid)
    {
        $id = uuidtoid($uuid, 'menu_managments');
        $data = MenuManagment::where('id', $id)->first();
        // dd($data);
        if ($data) {
            return view('Admin.cms.menuManagment.add-edit', compact('data'));
        }
        return redirect()->route('Admin.menuManagment.list')->with('error', 'something want to be worng');
    }

}

// "uuid" => null
// "menu_position" => null
// "menu_label" => null
// "link_type" => "internal"
// "block_list" => null
// ]
