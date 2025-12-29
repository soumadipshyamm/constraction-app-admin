<?php

namespace App\Http\Controllers\Company;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\Company\Project;
use App\Models\Company\Activities;
use App\Models\Company\SubProject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\BaseController;
use App\Exports\Activites\ActivitesExport;
use App\Imports\Activites\ActivitesImport;
use App\Exports\Activites\DemoActivitesExport;
use App\Exports\Activites\ActivitesImportFailExport;
use App\Models\Company\StoreWarehouse;

class ActivitiesController extends BaseController
{
    public function projectSubprojectWiseList(Request $request)
    {
        $authCompany = Auth::guard('company')->user();
        $companyId = searchCompanyId($authCompany->id); // Assuming `searchCompanyId` is a custom function to find company ID
        Session::put('navbar', 'show');
        $this->setPageTitle('Companies');
        $activities = Activities::with('units', 'project', 'subproject')->where('company_id', $companyId)->whereNull('parent_id');
        //
        if ($request->has('project')) {
            $activities->Where('project_id', $request->project);
        }
        if ($request->has('subproject')) {
            $activities->Where('subproject_id', $request->subproject);
        }
        if ($request->has('project') || $request->has('subproject')) {
            $activities = $activities->where(function ($q) use ($request) {
                $q->Where('project_id', $request->project);
                $q->Where('subproject_id', $request->subproject);
            });
        }
        $activities = $activities->get();

        if ($request->ajax()) {
            $activities = $activities->append($request->all());
            $datas = $activities;
            return view('Company.activities.include.list', compact('activities'))->render();
        }
        $datas = $activities;
        return view('Company.activities.index', compact('activities'));
    }
    public function index(Request $request)
    {
        $authCompany = Auth::guard('company')->user();
        $companyId = searchCompanyId($authCompany->id); // Assuming `searchCompanyId` is a custom function to find company ID
        Session::put('navbar', 'show');
        $this->setPageTitle('Companies');
        $activities = Activities::with('units', 'project', 'subproject', 'parent', 'children')->where('company_id', $companyId)->whereNull('parent_id');

        if ($request->has('project')) {
            $activities->Where('project_id', $request->project);
        }
        if ($request->has('subproject')) {
            $activities->Where('subproject_id', $request->subproject);
        }
        if ($request->has('project') || $request->has('subproject')) {
            $activities = $activities->where(function ($q) use ($request) {
                $q->Where('project_id',  $request->project);
                $q->orWhere('subproject_id',  $request->subproject);
            });
        }
        $activities = $activities->get();

        if ($request->ajax()) {
            // dd($activities);
            $activities = $activities->append($request->all());
            $datas = $activities;
            return view('Company.activities.include.list', compact('activities'))->render();
        }
        $datas = $activities;
        // Log::info("*********************************************4");
        // Log::info($datas);
        return view('Company.activities.index', compact('activities'));
    }
    // ***************************************************************************************************
    public function add(Request $request)
    {
        Session::put('navbar', 'show');
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);

        if ($request->isMethod('post')) {
            $checkAdditionalFeatures = fetchDataActivities($companyId, $request->project);
            $isSubscription = checkSubscriptionPermission($companyId, 'activities');

            $validatedData = $request->validate([
                'project' => 'required',
                'type' => 'required|in:heading,activites',
                'heading' => 'required_if:type,activites',
                'activities' => 'required',
            ]);

            $subproject = isset($request->subproject) && $request->subproject != "null" ? $request->subproject : NULL;
            // dd($subproject);
            // Determine the sl_no
            if ($request->type == 'heading') {
                // For headings, sl_no starts from 1 and increments for each new heading
                $slNo = Activities::whereNull('parent_id')->where('company_id', $companyId)->max('sl_no') + 1 ?? 1;
            } else {
                // For activities under a parent (heading), sl_no follows parent.child format
                $parent = Activities::where('id', $request->heading)->first();
                $parentSlNo = $parent->sl_no; // Get the parent's sl_no
                $lastChildSlNo = Activities::where('parent_id', $request->heading)->max('sl_no');
                // dd($parentSlNo, $lastChildSlNo);
                if (strpos($lastChildSlNo, '.') === false) {
                    // dd($parentSlNo, $lastChildSlNo);
                    // If the parent has no child, we start with "parentSlNo.1"
                    $slNo = $parentSlNo . '.1';
                } else {
                    // dd($parentSlNo, $lastChildSlNo);
                    // If parent has children, increment the child number
                    $lastChildNumber = substr(strrchr($lastChildSlNo, '.'), 1); // Get last child's last number
                    $slNo = $parentSlNo . '.' . ($lastChildNumber + 1);
                }

                // For grandchildren or nested children
                $lastChildSlNo = Activities::where('parent_id', $request->heading)->max('sl_no');
                $parentParts = explode('.', $parentSlNo);
                $parentSlNoLast = end($parentParts); // This will be the "1" in "1.1" (the first part before the dot)

                $siblingCount = Activities::where('parent_id', $request->heading)->count(); // Count how many siblings exist
                $newSlNo = $parentSlNoLast . '.' . ($siblingCount + 1);
            }

            // dd($request->all());
            // If UUID is provided, update the activity
            if ($request->uuid) {
                try {
                    $id = uuidtoid($request->uuid, 'activities');
                    Activities::where('id', $id)->update([
                        'project_id' => $request->project,
                        'subproject_id' => $subproject,
                        'type' => $request->type,
                        'parent_id' => $request->heading,
                        'activities' => $request->activities,
                        'unit_id' => $request->unit_id ?? null,
                        'qty' => $request->quantity,
                        'rate' => $request->rate,
                        'amount' => $request->amount,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                    ]);
                    DB::commit();
                    return redirect()->route('company.activities.list')->with('success', 'Activities Updated Successfully');
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('company.activities.list')->with('false', $e->getMessage());
                }
            } else {
                // Ensure subscription limits are not exceeded
                // if (count($checkAdditionalFeatures) < $isSubscription->is_subscription) {
                try {
                    // dd($subproject);
                    $lkjhbv = Activities::create([
                        'uuid' => Str::uuid(),
                        'project_id' => $request->project,
                        'subproject_id' => $subproject,
                        'type' => $request->type,
                        'sl_no' => $slNo,
                        'parent_id' => $request->heading,
                        'activities' => $request->activities,
                        'unit_id' => $request->unit_id ?? null,
                        'qty' => $request->quantity,
                        'rate' => $request->rate,
                        'amount' => $request->amount,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                        'company_id' => $companyId,
                    ]);
                    // dd($lkjhbv);
                    DB::commit();
                    return redirect()->route('company.activities.list')->with('success', 'Activities Created Successfully');
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('company.activities.list')->with('false', $e->getMessage());
                }
                // } else {
                //     return redirect()->back()->with('expired', true);
                // }
            }
        }

        return view('Company.activities.add-edit');
    }
    // ***************************************************************************************************
    public function edit(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'activities');
        $data = Activities::where('id', $id)->first();
        if ($data) {
            return view('Company.activities.add-edit', compact('data'));
        }
        return redirect()->route('company.activities.list')->with('error', 'something want to be worng');
    }
    // *****************************sub projects**********************************************************
    public function subprojects(Request $request, $projectId)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $subprojects = Project::where('company_id', $companyId)->where('id', $projectId)
            ->with('subProject')->get();
        return response()->json($subprojects);
    }

    public function storeprojects(Request $request, $projectId)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $storeprojects = Project::where('company_id', $companyId)->where('id', $projectId)
            ->with('StoreWarehouse')->get();
        return response()->json($storeprojects);
    }
    public function projectsstore(Request $request, $projectId)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $storeprojects = StoreWarehouse::where('company_id', $companyId)->where('projects_id', $projectId)->get();
        return response()->json($storeprojects);
    }
    // **************************Excel Export & Import*********************************
    public function bulkbulkupload()
    {
        return view('Company.activities.bulkupload');
    }
    /**
     * It will return \Illuminate\Support\Collection
     */
    public function export(Request $request)
    {
        // dd($request->all());
        $project = $request->project;
        $subprojects = $request->subprojects;
        // $project=$request->project;
        return Excel::download(new ActivitesExport($project, $subprojects), 'activites.xlsx');
    }


    public function import(Request $request)
    {
        $authCompany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authCompany);

        $additionalFeatures = fetchDataActivities($companyId, $request->project);
        $subscription = checkSubscriptionPermission($companyId, 'activities');

        // if (count($additionalFeatures) < $subscription->is_subscription) {
        try {
            $file = $request->file('file');
            $project = $request->project;
            $subproject = $request->subproject;
            $cacheKey = 'tmpcachekey';

            Cache::put($cacheKey, []);

            Excel::import(new ActivitesImport($project, $subproject, $companyId, $cacheKey), $file);
            $importedData = Cache::get($cacheKey);

            // if (empty($importedData)) {
            return redirect()->route('company.activities.list')->with('success', 'Import Data Uploaded Successfully');
            // } else {
            //     // return redirect()->route('company.activities.nonImportData');
            // }
        } catch (\Exception $e) {
            Log::error('Error importing Excel file: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error importing Excel file');
        }
        // } else {
        //     return redirect()->back()
        //         ->with('expired', true);
        // }
    }

    // public function import(Request $request)
    // {
    //     // Authentication & company
    //     $authCompany = Auth::guard('company')->user()?->id;
    //     if (!$authCompany) {
    //         return redirect()->back()->withErrors(['auth' => 'Unauthorized']);
    //     }

    //     $companyId = searchCompanyId($authCompany);
    //     $project = $request->input('project');
    //     $subproject = $request->input('subproject');

    //     // Validation
    //     $request->validate([
    //         'file' => 'required|file|mimes:xlsx,xls,csv',
    //         'project' => 'required|exists:projects,id',
    //     ]);

    //     // Optional: Subscription check (uncomment when needed)
    //     // $additionalFeatures = fetchDataActivities($companyId, $project);
    //     // $subscription = checkSubscriptionPermission($companyId, 'activities');
    //     // if (count($additionalFeatures) >= ($subscription->is_subscription ?? PHP_INT_MAX)) {
    //     //     return redirect()->back()->with('expired', true);
    //     // }

    //     // Generate a user+project-scoped cache key
    //     $cacheKey = "import_errors_{$companyId}_{$project}_" . uniqid();

    //     try {
    //         // Clear any previous import errors for this session
    //         Cache::forget($cacheKey);

    //         $file = $request->file('file');

    //         // Run import
    //         Excel::import(new ActivitesImport($project, $subproject, $companyId, $cacheKey), $file);

    //         // Check for import errors or non-imported rows
    //         $nonImportedData = Cache::get($cacheKey, []);

    //         if (!empty($nonImportedData)) {
    //             // Store for review on next page
    //             session(['non_imported_data' => $nonImportedData]);
    //             Cache::forget($cacheKey); // cleanup
    //             return redirect()->route('company.activities.nonImportData');
    //         }

    //         return redirect()->route('company.activities.list')
    //             ->with('success', 'Activities imported successfully.');
    //     } catch (\Exception $e) {
    //         Log::error('Import failed: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    //         return redirect()->back()->with('error', 'Failed to import file. Please check format and try again.');
    //     }
    // }
    public function DemoExportUnit()
    {
        $importedData =  Cache::get('tmpcachekey');
        return Excel::download(new DemoActivitesExport, 'activites.xlsx');
    }
    // *************************non Import Data*************************************************************
    public function nonImportData(Request $request)
    {
        $dataCount = Count(Cache::get('tmpcachekey'));
        return view('Company.activities.non-import-data', compact('dataCount'));
    }
    public function NonImportDataExport()
    {
        $importedData =  Cache::get('tmpcachekey');
        if ($importedData > 0) {
            $exportFileName = 'activities_not_insert.xlsx';
            return Excel::download(new ActivitesImportFailExport($importedData), $exportFileName);
        } else {
            return redirect()->route('company.activities.list')->with('success', 'No data to export.');
        }
    }
    // ******************************************************************************************
    public function activitiesAdd(Request $request)
    {
        Session::put('navbar', 'show');
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $id = $request->pid;
        $slno = Activities::where('parent_id', $id)->orderBy('id', 'DESC')->first();
        $subproject = isset($request->subproject) ? $request->subproject : null;
        try {
            $data = [
                'uuid' => Str::uuid(),
                'project_id' => $request->project_id,
                'subproject_id' => $subproject,
                'sl_no' => $request->slno,
                'type' => $request->type,
                'parent_id' => $request->pid,
                'activities' => $request->activities,
                'unit_id' => $request->unit_id,
                'qty' => $request->quantity,
                'rate' => $request->rate,
                'amount' => $request->amount,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'company_id' => $companyId,
            ];
            $isUpdated = Activities::create($data);
            DB::commit();
            return response()->json(['success' => 'true', 'message' => 'Successfully Done.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
            return redirect()->route('company.activities.list')->with('false', $e->getMessage());
        }
    }
    public function activitiesEdit(Request $request)
    {
        $data = Activities::where('id', $request->dataId)->first();
        return $data;
    }
    public function activitiesUpdate(Request $request)
    {
        Session::put('navbar', 'show');
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $pId = $request->pid;
        $slno = Activities::where('parent_id', $pId)->orderBy('id', 'DESC')->first();
        $data = [
            'project_id' => $request->project_id,
            'subproject_id' => $request->subproject_id,
            'sl_no' => $request->slno,
            'type' => $request->type,
            'parent_id' => $request->pid,
            'activities' => $request->activities,
            'unit_id' => $request->unit_id,
            'qty' => $request->quantity,
            'rate' => $request->rate,
            'amount' => $request->amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'company_id' => $companyId,
        ];
        $isUpdated = Activities::where('id', $request->updateId)->update($data);
        return response()->json(['success' => 'true', 'message' => 'Successfully Done.'], 200);
    }
    // ****************Activtes Copy*******************************************************
    public function copyActivites(Request $request)
    {
        $authCompany = Auth::guard('company')->user();
        $companyId = searchCompanyId($authCompany->id); // Assuming `searchCompanyId` is a custom function to find company ID
        Session::put('navbar', 'show');
        $this->setPageTitle('Companies');
        $activities = Activities::with('units', 'project', 'subproject')->where('company_id', $companyId)->whereNull('parent_id');
        if ($request->has('project')) {
            $activities->Where('project_id',  $request->project);
        }
        if ($request->has('subproject')) {
            $activities->Where('subproject_id',  $request->subproject);
        }
        if ($request->has('project') || $request->has('subproject')) {
            $activities = $activities->where(function ($q) use ($request) {
                $q->Where('project_id',  $request->project);
                $q->Where('subproject_id',  $request->subproject);
            });
        }
        $activities = $activities->get();
        if ($request->ajax()) {
            $activities = $activities->append($request->all());
            $datas = $activities;
            return view('Company.activities.activite_copy.list', compact('activities'))->render();
        }
        $datas = $activities;
        return view('company.activities.activites-copy', compact('activities'));
    }

    public function addCopyActivites(Request $request)
    {
        $authCompany = Auth::guard('company')->user();
        $companyId = searchCompanyId($authCompany->id);
        $fetchDatas = $request->all();
        $to_subproject = $fetchDatas['to_subproject'] ?? null;
        $to_project = $fetchDatas['to_project'];
        $heading = $fetchDatas['heading'] ?? "";
        $type = $fetchDatas['type'];
        $activitiesName = $fetchDatas['activities'] ?? '';
        $findId = [];
        $parentId = null;
        $newActivities = [];

        foreach ($fetchDatas['id'] as $key => $data) {
            $findId[] = $data;
        }

        $activities = Activities::where('company_id', $companyId)
            ->whereIn('id', $findId)
            ->get();

        // if (isset($type) && isset($activitiesName)) {
        //     $newActivity = [
        //         'uuid' => Str::uuid(),
        //         'parent_id' => $heading,
        //         'project_id' => $to_project,
        //         'subproject_id' => $to_subproject,
        //         'type' => $type,
        //         'activities' => $activitiesName,
        //         'unit_id' => '',
        //         'qty' => '',
        //         'rate' => '',
        //         'amount' => '',
        //         'company_id' => $companyId,
        //     ];
        //     dd($newActivity);
        //     $createdActivity = Activities::create($newActivity);
        // $parentId = $createdActivity->id;
        // }
        // else {
        foreach ($activities as $activity) {
            $newActivity = [
                'uuid' => Str::uuid(),
                'parent_id' => $parentId,
                'project_id' => $to_project,
                'subproject_id' => $to_subproject,
                'type' => $activity->type,
                'activities' => $activity->activities,
                'unit_id' => $activity->unit_id,
                'qty' => $activity->qty,
                'rate' => $activity->rate,
                'amount' => $activity->amount,
                'company_id' => $companyId,
            ];
            $createdActivity = Activities::create($newActivity);
            $parentId = $createdActivity->id;
            $newActivities[] = $createdActivity;
        }
        // }
        return redirect()->route('company.activities.list')->with('success', 'Activities copied successfully');
    }

    public function findId(Request $request)
    {
        $findActivites = [];
        foreach ($request->selectedItems as  $key => $value) {
            $findActivites[] = Activities::find($value);
        }
        return $findActivites;
    }

    public function activiteFieldHtml($p, $sp)
    {
        return getchildActivites($p, $sp);
    }
}



    // public function add(Request $request)
    // {
    //     Session::put('navbar', 'show');
    //     $authConpany = Auth::guard('company')->user()->id;
    //     $companyId = searchCompanyId($authConpany);
    //     if ($request->isMethod('post')) {
    //         $checkAdditionalFeatures = fetchDataActivities($companyId, $request->project);
    //         $isSubscription = checkSubscriptionPermission($companyId, 'activities');
    //         $validatedData = $request->validate([
    //             'project' => 'required',
    //             'type' => 'required|in:heading,activites',
    //             'heading' => 'required_if:type,activites',
    //             'activities' => 'required',
    //             // 'qty' => 'required_if:type,activites',
    //             // 'rate' => 'required_if:type,activites',
    //             // 'amount' => 'required_if:type,activites',
    //             // 'start_date' => 'required_if:type,activites',
    //         ]);
    //         $subproject = isset($request->subproject) ? $request->subproject : null;
    //         $slNo = $request->type == 'heading' ? '1' : '1.1';
    //         if ($request->uuid) {
    //             try {
    //                 $id = uuidtoid($request->uuid, 'activities');
    //                 Activities::where('id', $id)->update([
    //                     'project_id' => $request->project,
    //                     'subproject_id' => $subproject,
    //                     'type' => $request->type,
    //                     'parent_id' => $request->heading,
    //                     'activities' => $request->activities,
    //                     'unit_id' => $request->unit_id ?? null,
    //                     'qty' => $request->quantity,
    //                     'rate' => $request->rate,
    //                     'amount' => $request->amount,
    //                     'start_date' => $request->start_date,
    //                     'end_date' => $request->end_date,
    //                 ]);
    //                 DB::commit();
    //    return redirect()->route('company.activities.list')->with('success', 'Activities Updated Successfully');
    //             } catch (\Exception $e) {
    //                 DB::rollBack();
    //                 logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
    //                 return redirect()->route('company.activities.list')->with('false', $e->getMessage());
    //             }
    //         } else {
    //             if (count($checkAdditionalFeatures) < $isSubscription->is_subscription) {
    //                 try {
    //                     $asdfg = Activities::create([
    //                         'uuid' => Str::uuid(),
    //                         'project_id' => $request->project,
    //                         'subproject_id' => $subproject,
    //                         'type' => $request->type,
    //                         'sl_no' => $slNo,
    //                         'parent_id' => $request->heading,
    //                         'activities' => $request->activities,
    //                         'unit_id' => $request->unit_id ?? null,
    //                         'qty' => $request->quantity,
    //                         'rate' => $request->rate,
    //                         'amount' => $request->amount,
    //                         'start_date' => $request->start_date,
    //                         'end_date' => $request->end_date,
    //                         'company_id' => $companyId,
    //                     ]);
    //                     DB::commit();
    //    return redirect()->route('company.activities.list')->with('success', 'Activities Created Successfully');
    //                 } catch (\Exception $e) {
    //                     DB::rollBack();
    //                     logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
    //                     return redirect()->route('company.activities.list')->with('false', $e->getMessage());
    //                 }
    //             } else {
    //                 return redirect()
    //                     ->back()
    //                     ->with('expired', true);
    //             }
    //         }
    //     }
    //     return view('Company.activities.add-edit');
    // }
