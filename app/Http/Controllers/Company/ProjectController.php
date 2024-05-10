<?php

namespace App\Http\Controllers\Company;

use App\Exports\Projects\ProjectsExport;
use App\Http\Controllers\BaseController;
use App\Models\Company\Client;
use App\Models\Company\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Session::put('navbar', 'show');
        $this->setPageTitle('Projects');
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);

        $datas = Project::with('client', 'companys', 'companiesProject')->where('company_id', $companyId)->where('is_active', 1);
        if ($request->has('search_keyword')) {
            $datas->Where('project_name', 'LIKE', '%' . $request->search_keyword . '%');
        }
        if ($request->has('project_status')) {
            $datas->Where('project_completed', $request->project_status);
        }
        if ($request->has('search_keyword') || $request->has($request->project_status)) {
            $datas = $datas->where(function ($q) use ($request) {
                $q->Where('project_name', 'LIKE', '%' . $request->search_keyword . '%');
                $q->Where('project_completed', 'LIKE', '%' . $request->project_status . '%');
            });
        }
        $datas = $datas->paginate(10);
        if ($request->ajax()) {
            $datas = $datas->appends($request->all());
            return view('Company.projects.include.project-list', compact('datas'))->render();
        }
        return view('Company.projects.index', compact('datas'));
    }

    public function add(Request $request)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        if ($request->isMethod('post')) {
            $request->validate([
                'project_name' => 'required',
                'planned_start_date' => 'required',
                'address' => 'required',
                'planned_end_date' => 'date',
                'tag_company' => 'required',
                'own_project_or_contractor' => 'required|in:yes,no',
                'client_name' => 'required_if:own_project_or_contractor,yes',
                'client_company_address' => 'required_if:own_project_or_contractor,yes',
                'client_company_name' => 'required_if:own_project_or_contractor,yes',
                'client_designation' => 'required_if:own_project_or_contractor,yes',
                'client_email' => 'required_if:own_project_or_contractor,yes',
                'client_phone' => 'required_if:own_project_or_contractor,yes',
            ]);
            // dd($request->all());
            DB::beginTransaction();
            if ($request->uuid) {
                try {
                    $pid = uuidtoid($request->uuid, 'projects');
                    // dd($pid);
                    // if (!empty($request->hasFile('logo'))) {
                    // dd($request->all());
                    //     $isProjectUpdated = Project::where('id', $pid)->update([
                    //         'project_name' => $request->project_name,
                    //         'planned_start_date' => $request->planned_start_date,
                    //         'address' => $request->address,
                    //         'planned_end_date' => $request->planned_end_date,
                    //         'own_project_or_contractor' => $request->own_project_or_contractor,
                    //         'project_completed' => $request->project_completed == 'yes' ? 'yes' : 'no',
                    //         'company_id' => $companyId,
                    //         'companies_id' => $request->tag_company,
                    //         'logo' => getImgUpload($request->logo, 'logo'),
                    //     ]);
                    // } else {
                    // dd($request->all());
                    $fetchLogo = Project::find($pid);
                    $isProjectUpdated = Project::where('id', $pid)->update([
                        'project_name' => $request->project_name,
                        'planned_start_date' => $request->planned_start_date,
                        'address' => $request->address,
                        'planned_end_date' => $request->planned_end_date,
                        'own_project_or_contractor' => $request->own_project_or_contractor,
                        'project_completed' => $request->project_completed == 'yes' ? 'yes' : 'no',
                        'company_id' => $companyId,
                        'companies_id' => $request->tag_company,
                        'project_completed_date' => $request->project_completed_date,
                        'logo' => $request->logo ? getImgUpload($request->logo, 'logo') : $fetchLogo->logo,
                    ]);
                    // }
                    // dd($request->own_project_or_contractor);
                    if ($request->own_project_or_contractor == 'yes') {
                        if ($request->clientUuid != null) {
                            $cid = uuidtoid($request->clientUuid, 'clients');
                            $isClientUpdated = Client::where('id', $cid)->where('project_id', $pid)->update([
                                'client_name' => $request->client_name,
                                'client_designation' => $request->client_designation,
                                'client_email' => $request->client_email,
                                'client_phone' => $request->client_phone,
                                'client_mobile' => $request->client_mobile,
                                'client_company_name' => $request->client_company_name,
                                'client_company_address' => $request->client_company_address,
                            ]);
                            if ($isClientUpdated) {
                                DB::commit();
                                return redirect()->route('company.project.list')->with('success', 'Project Updated Successfully');
                            }
                        } else {
                            // dd($isProjectUpdated);
                            $isClientCreated = Client::create([
                                'uuid' => Str::uuid(),
                                'client_name' => $request->client_name,
                                'client_designation' => $request->client_designation,
                                'client_email' => $request->client_email,
                                'client_phone' => $request->client_phone,
                                'client_mobile' => $request->client_mobile,
                                'client_company_name' => $request->client_company_name,
                                'client_company_address' => $request->client_company_address,
                                'project_id' => $pid,
                            ]);
                            if ($isClientCreated) {
                                // dd($request->all());
                                DB::commit();
                                return redirect()->route('company.project.list')->with('success', 'Project Updated Successfully');
                            }
                        }
                    } else {
                        // dd($request->all());
                        if ($request->clientUuid) {
                            $cid = uuidtoid($request->clientUuid, 'clients');
                            $res = Client::where('id', $cid)->delete();
                        }
                        DB::commit();
                        return redirect()->route('company.project.list')->with('success', 'Project Updated Successfully');
                    }
                    //  dd($request->all());
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('company.project.list')->with('error', 'something want to be worng');
                }
            } else {
                //create a new project
                try {
                    $isProjectCreated = Project::create([
                        'uuid' => Str::uuid(),
                        'project_name' => $request->project_name,
                        'planned_start_date' => $request->planned_start_date,
                        'address' => $request->address,
                        'planned_end_date' => $request->planned_end_date,
                        'own_project_or_contractor' => $request->own_project_or_contractor,
                        'project_completed' => $request->project_completed == 'yes' ? 'yes' : 'no',
                        'company_id' => $companyId,
                        'companies_id' => $request->tag_company,
                        'project_completed_date' => $request->project_completed_date,
                        'logo' => $request->logo ? getImgUpload($request->logo, 'logo') : '',
                    ]);
                    if ($request->own_project_or_contractor == 'yes') {
                        $isClientCreated = Client::create([
                            'uuid' => Str::uuid(),
                            'client_name' => $request->client_name,
                            'client_designation' => $request->client_designation,
                            'client_email' => $request->client_email,
                            'client_phone' => $request->client_phone,
                            'client_mobile' => $request->client_mobile,
                            'client_company_name' => $request->client_company_name,
                            'client_company_address' => $request->client_company_address,
                            'project_id' => $isProjectCreated->id,
                        ]);
                    }
                    if ($isProjectCreated) {
                        DB::commit();
                        return redirect()->route('company.project.list')->with('success', 'Project Created Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    // dd($e->getMessage());
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('company.project.list')->with('error', $e->getMessage());
                }
            }
        }
        return view('Company.projects.add-edit');
    }
    public function edit(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'projects');
        $data = Project::with('client', 'companys', 'companiesProject')->where('id', $id)->first();
        // dd($data);
        if ($data) {
            return view('Company.projects.add-edit', compact('data'));
        }
        return $this->responseJson(false, 200, 'No data found');
    }

    public function export()
    {
        return Excel::download(new ProjectsExport, 'project.xlsx');
    }

}
// "_token" => "yvgQHsQ4gMmdXYFtFqQOcVYy8JaWCWIECnuIUG18"
// "uuid" => "c2bafc01-b5a7-4517-89a2-11fbdd9d7508"
// "clientUuid" => null
// "project_name" => "zippyFoodDelivery"
// "planned_start_date" => "2023-08-10"
// "address" => "kolkata"
// "planned_end_date" => "2023-08-26"
// "own_project_or_contractor" => "yes"
// "client_company_name" => "aaaaaaaaa"
// "client_company_address" => "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
// "client_name" => "vendor 1"
// "client_designation" => "Owner"
// "client_email" => "abcd@abc.com"
// "client_phone" => "08972344111"
// "client_mobile" => null
// "tag_company" => "1"
// "project_completed" => "yes"
