<?php
namespace App\Http\Controllers\Company;
use App\Exports\Subprojects\SubprojectsExport;
use App\Http\Controllers\BaseController;
use App\Models\Company\Project;
use App\Models\Company\SubProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
class SubProjectController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $this->setPageTitle('sub-Projects');
        $datas = Project::with('subProject')->where('company_id', $companyId)->where('is_active', 1);
        // dd($datas);
        if ($request->has('search_keyword')) {
            $searchKeyword = '%' . $request->search_keyword . '%';
            $datas->whereHas('subProject', function ($q) use ($searchKeyword) {
                $q->where('name', 'LIKE', $searchKeyword);
            });
        }
        if ($request->has('project') && $request->project != null) {
            $datas->Where('id', $request->project);
        }

        if ($request->has('search_keyword') || ($request->has('project') && $request->project != null)) {
            $searchKeyword = '%' . $request->input('search_keyword') . '%';
            $project = $request->input('project');
            $datas->where(function ($query) use ($project, $searchKeyword) {
                $query->where('id', 'LIKE', "%$project%")
                    ->orWhereHas('subProject', function ($subQuery) use ($searchKeyword) {
                        $subQuery->where('name', 'LIKE', $searchKeyword);
                    });
            });
        }
        $datas = $datas->paginate(10);
        if ($request->ajax()) {
            $datas = $datas->appends($request->all());
            // dd($datas);
            return view('Company.subProjects.include.subproject-list', compact('datas'))->render();
            // return response()->json(['status' => 200, 'content' => $content]);
        }
        return view('Company.subProjects.index', compact('datas'));
    }
    public function add(Request $request)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        if ($request->isMethod('post')) {
            $getProjectsId = $request->input('tag_project');
            // dd($getProjectsId);
            $request->validate([
                'name' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'tag_project'=>'required'
            ],[],[
                'tag_project'=>'kindly tag project & save'
            ]);
            DB::beginTransaction();
            if ($request->uuid) {
                try {
                    $id = uuidtoid($request->uuid, 'sub_projects');
                    $isProjectUpdated = SubProject::where('id', $id)->update([
                        'name' => $request->name,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                    ]);
                    $project = Project::where('id', $getProjectsId)->first();
                    $projectId = $project->id;
                    // $isSubProjectCreated->project()->attach($projectId);
                    // $project = Project::where('id', $getProjectsId)->first();
                    // $projectId = $project->id;
                    // // dd($projectId);
                    // // $isProjectUpdated->project()->detach($projectId);
                    // $isProjectUpdated->project()->attach($projectId);
                    // dd($isClientUpdated);
                    if ($isProjectUpdated) {
                        DB::commit();
                        return redirect()->route('company.subProject.list')->with('success', 'Sub-Project Updated Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('company.subProject.list')->with('error', 'something want to be worng');
                }
            } else {
                try {
                    $isSubProjectCreated = SubProject::create([
                        'uuid' => Str::uuid(),
                        'name' => $request->name,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                        'company_id' => $companyId,
                    ]);
                    $project = Project::where('id', $getProjectsId)->first();
                    $projectId = $project->id;
                    $isSubProjectCreated->project()->attach($projectId);
                    if ($isSubProjectCreated) {
                        DB::commit();
                        return redirect()->route('company.subProject.list')->with('success', 'Sub-Project Created Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    // dd($e->getMessage());
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('company.subProject.list')->with('error', $e->getMessage());
                }
            }
        }
        return view('Company.subProjects.add-edit');
    }

    public function edit(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'sub_projects');
        $data = SubProject::where('id', $id)->with('project')->first();
        // dd($data);
        if ($data) {
            return view('Company.subProjects.add-edit', compact('data'));
        }
        return redirect()->route('company.subProject.list')->with('error', 'something want to be worng');
    }

    public function export()
    {
        return Excel::download(new SubprojectsExport, 'subproject.xlsx');
    }
}
