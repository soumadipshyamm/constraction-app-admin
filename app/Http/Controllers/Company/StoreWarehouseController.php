<?php

namespace App\Http\Controllers\Company;

use App\Exports\Stores\StoresExport;
use App\Http\Controllers\BaseController;
use App\Models\Company\Project;
use App\Models\Company\StoreWarehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class StoreWarehouseController extends BaseController
{
    // public function index(Request $request)
    // {
    //     $authConpany = Auth::guard('company')->user()->id;
    //     $companyId = searchCompanyId($authConpany);

    //     $this->setPageTitle('Store/Warehouse');

    //     // $datas = Project::with('StoreWarehouse')->where('company_id', $companyId)->where('is_active', 1);
    //     $datas = StoreWarehouse::with('project')->where('company_id', $companyId)->where('is_active', 1);
    //     // dd($datas->get());
    //     if ($request->has('search_keyword') && $request->search_keyword !== "") {
    //         $searchKeyword = '%' . $request->search_keyword . '%';
    //         // $datas->whereHas('StoreWarehouse', function ($q) use ($searchKeyword) {
    //         $datas->where('name', 'LIKE', '%', $searchKeyword, '%');
    //         // });
    //     }

    //     if ($request->has('project') && $request->project !== "") {
    //         $datas->whereHas('project', function ($q) use ($request) {
    //             $q->Where('id', $request->project);
    //         });
    //     }

    //     if ($request->has('search_keyword') || ($request->has('project') && $request->project !== "")) {
    //         $searchKeyword = '%' . $request->input('search_keyword') . '%';
    //         $project = $request->input('project');

    //         $datas->where(function ($query) use ($project, $searchKeyword) {
    //             // $query->where('id', 'LIKE', "%$project%")
    //             //     ->orWhereHas('StoreWarehouse', function ($subQuery) use ($searchKeyword) {
    //             //         $subQuery->where('name', 'LIKE', $searchKeyword);
    //             //     });
    //             $query->where('name', 'LIKE', '%', $searchKeyword, '%')
    //                 ->orWhereHas('project', function ($qq) use ($project) {
    //                     $qq->where('id', 'LIKE', "%$project%");
    //                 });
    //         });
    //     }

    //     $datas = $datas->paginate(10);
    //     // dd($datas);
    //     if ($request->ajax()) {
    //         $datas = $datas->appends($request->all());
    //         return view('Company.storeWarehouse.include.store-list', compact('datas'))->render();
    //     }
    //     return view('Company.storeWarehouse.index', compact('datas'));
    // }
    public function index(Request $request)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);

        $this->setPageTitle('Store/Warehouse');

        $datas = Project::with('StoreWarehouse')->where('company_id', $companyId)->where('is_active', 1);

        if ($request->has('search_keyword') && $request->search_keyword !== "") {
            $searchKeyword = '%' . $request->search_keyword . '%';
            $datas->whereHas('StoreWarehouse', function ($q) use ($searchKeyword) {
                $q->where('name', 'LIKE', $searchKeyword);
            });
        }

        if ($request->has('project') && $request->project !== "") {
            $datas->Where('id', $request->project);
        }

        if ($request->has('search_keyword') || ($request->has('project') && $request->project !== "")) {
            $searchKeyword = '%' . $request->input('search_keyword') . '%';
            $project = $request->input('project');

            $datas->where(function ($query) use ($project, $searchKeyword) {
                $query->where('id', 'LIKE', "%$project%")
                    ->orWhereHas('StoreWarehouse', function ($subQuery) use ($searchKeyword) {
                        $subQuery->where('name', 'LIKE', $searchKeyword);
                    });
            });
        }

        $datas = $datas->paginate(10);
        if ($request->ajax()) {
            $datas = $datas->appends($request->all());
            return view('Company.storeWarehouse.include.store-list', compact('datas'))->render();
        }
        return view('Company.storeWarehouse.index', compact('datas'));
    }

    public function add(Request $request)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required',
                'location' => 'required',
                'tag_project' => 'required',
            ]);
            DB::beginTransaction();
            if ($request->uuid) {
                try {
                    $id = uuidtoid($request->uuid, 'store_warehouses');
                    $isProjectUpdated = StoreWarehouse::where('id', $id)->update([
                        'name' => $request->name,
                        'location' => $request->location,
                        'projects_id' => $request->tag_project,
                    ]);
                    // dd($isClientUpdated);
                    if ($isProjectUpdated) {
                        DB::commit();
                        return redirect()->route('company.storeWarehouse.list')->with('success', 'Store/Warehouse Updated Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('company.storeWarehouse.list')->with('error', 'something want to be worng');
                }
            } else {
                try {
                    $isSubProjectCreated = StoreWarehouse::create([
                        'uuid' => Str::uuid(),
                        'name' => $request->name,
                        'location' => $request->location,
                        'projects_id' => $request->tag_project,
                        'company_id' => $companyId,
                    ]);
                    // dd($isClientCreated->id);
                    if ($isSubProjectCreated) {
                        DB::commit();
                        return redirect()->route('company.storeWarehouse.list')->with('success', 'Store Warehouse Created Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    // dd($e->getMessage());
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('company.storeWarehouse.list')->with('error', $e->getMessage());
                }
            }
        }
        return view('Company.storeWarehouse.add-edit');
    }

    public function edit(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'store_warehouses');
        $data = StoreWarehouse::where('id', $id)->first();
        // dd($data);
        if ($data) {
            return view('Company.storeWarehouse.add-edit', compact('data'));
        }
        return redirect()->route('company.storeWarehouse.list')->with('error', 'something want to be worng');
    }

    public function export()
    {
        return Excel::download(new StoresExport, 'stores.xlsx');
    }
}
