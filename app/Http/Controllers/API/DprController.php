<?php

namespace App\Http\Controllers\API;

use App\Models\API\Dpr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Resources\API\DPR\DprResources;
use App\Models\API\Hinderance;
use App\Models\API\Safety;
use App\Models\Company\Activities;
use App\Models\Company\ActivityHistory;
use App\Models\Company\Assets;
use App\Models\Company\AssetsHistory;
use App\Models\Company\Labour;
use App\Models\Company\LabourHistory;
use App\Models\Company\Materials;
use App\Models\Company\MaterialsHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class DprController extends BaseController
{
    public function index(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user();
        $this->setPageTitle('User Management');
        $datas = Dpr::with('assets', 'activities', 'labour', 'material', 'historie', 'safetie')->where('company_id', $authCompany->company_id)->where('user_id', $authCompany->id)->orderBy('id', 'desc')->get();
        if (count($datas) > 0) {
            return $this->responseJson(true, 200, 'Fetch DPR List Successfullsy', $datas);
        } else {
            return $this->responseJson(true, 200, 'DPR List Data Not Found', []);
        }
    }

    public function add(Request $request)
    {
        // dd($request->all());
        log_daily(
            'DPR',
            'DPR Add/Update request received with data.',
            'add',
            'info',
            json_encode($request->all())
        );
        // dd(generateUniqueSixDigitNumber('dprs', 'dpr_no'));
        $authCompany = Auth::guard('company-api')->user();

        DB::beginTransaction();
        $checkDpr = Dpr::where(['date' => Carbon::now()->format('Y-m-d'), 'projects_id' => $request->projects_id, 'user_id' => $authCompany->id])->where('company_id', $authCompany->company_id);
        if (isset($request->sub_projects_id) && !empty($request->sub_projects_id)) {
            $checkDpr = $checkDpr->where('sub_projects_id', $request->sub_projects_id);
        }
        $checkDpr = $checkDpr->first();
        // dd($request->all());

        try {
            // dd($checkDpr);
            if ($request->id == null && $checkDpr == null) {
                $isDprDatas = new Dpr();
                $isDprDatas->name = $request->name;
                $isDprDatas->dpr_no = generateUniqueSixDigitNumber('dprs', 'dpr_no');
                $isDprDatas->date = Carbon::now()->format('Y-m-d');
                $isDprDatas->company_id = $authCompany->company_id;
                $isDprDatas->user_id = $authCompany->id;
                $isDprDatas->projects_id = $request->projects_id;
                $isDprDatas->sub_projects_id = $request->sub_projects_id ?? null;
            } else {
                $isDprDatas = Dpr::find($checkDpr->id);
            }
            // dd($isDprDatas);
            $isDprDatas->projects_id = $request->projects_id;
            $isDprDatas->sub_projects_id = $request->sub_projects_id ?? null;
            $isDprDatas->staps = $request->staps;
            $isDprDatas->activities_id = $request->activities_id;
            $isDprDatas->assets_id = $request->assets_id;
            $isDprDatas->labours_id = $request->labours_id;
            $isDprDatas->save();
            if ($request->id) {
                $message = 'DPR Details Updated Successfullsy';
            } else {
                $message = 'DPR Details Created Successfullsy';
            }
            // dd($isDprDatas);
            if (isset($isDprDatas)) {
                DB::commit();
                addNotifaction($message, $isDprDatas, $request->projects_id, $authCompany->company_id);
                return $this->responseJson(true, 200, $message, $isDprDatas);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    public function edit($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Dpr::where('id', $uuid)->where('company_id', $authCompany)->get();
        $message = $data->isNotEmpty() ? 'Fetch DPR List Successfully' : 'DPR List Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }

    public function delete($uuid)
    {
        log_daily(
            'DPR',
            'DPR Delete request received with data.',
            'delete',
            'info',
            json_encode(['uuid' => $uuid])
        );
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Dpr::where('id', $uuid)
            ->where('company_id', $authCompany)
            ->first(); // Fetch the record first
        if ($data) { // Check if the record exists
            $result = $data->delete(); // Delete the record
            $message = 'DPR Delete Successfully';
        } else {
            $result = false; // No record found
            $message = 'DPR Data Not Found';
        }
        addNotifaction($message, $data, $data?->projects_id ?? null, $authCompany->company_id);
        return $this->responseJson(true, 200, $message, $result);
    }

    public function dprCheck(Request $request)
    {
        log_daily(
            'DPR',
            'DPR Check request received with data.',
            'check',
            'info',
            json_encode($request->all())
        );
        $authCompany = Auth::guard('company-api')->user();
        $datas = Dpr::where('staps', '!=', 7)
            ->where('company_id', $authCompany->company_id)
            ->where('user_id', $authCompany->id)
            ->whereNotNull('projects_id')
            ->orderBy('id', 'desc')
            ->get();
        // dd($datas);
        $result = DprResources::collection($datas); // Ensure proper spacing
        $message = 'Fetch DPR List Successfully';
        addNotifaction($message, $result, $datas->first()->projects_id ?? null, $authCompany->company_id); // Use null coalescing operator
        return $this->responseJson(true, 200, $message, $result);
    }


    // *********************************************************************************************
    /**
     * Generate a PDF from DPR data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generatePDF(Request $request)
    {
        // Retrieve DPR ID from request
        $dprId = $request->dpr;

        // Retrieve authenticated company user
        $authCompany = Auth::guard('company-api')->user();

        // Set page title (not clear what this method does; assuming it sets some kind of title)
        $this->setPageTitle('User Management');

        // Retrieve DPR data with related models
        $datas = Dpr::with('assets', 'activities', 'labour', 'material', 'historie', 'safetie')
            ->where('id', $dprId)
            ->where('company_id', $authCompany->company_id)
            ->where('user_id', $authCompany->id)
            ->get();
        // Assign project and subproject IDs to data array
        $data['project_id'] = $datas[0]->projects_id;
        $data['subproject_id'] = $datas[0]->sub_projects_id;
        $data['dpr_id'] = $datas[0]->id;

        // dd($datas);

        // Generate PDF from view
        $pdf = PDF::loadView('common.pdf.dprs', compact('datas'));

        // Generate PDF content
        $pdfContent = $pdf->output();

        // Define filename with timestamp
        $filename = 'dpr_' . date('YmdHis') . '.pdf';

        // Define file path
        $filePath = storage_path('app/public/' . $filename);

        // Save PDF to storage
        $pdf->save($filePath);

        // Get base URL
        $baseUrl = URL::to('/');

        // Construct PDF URL
        $pdfUrl = $baseUrl . '/storage/' . $filename;

        // Return JSON response with success message and PDF URL
        return response()->json([
            'name' => $filename,
            'message' => 'PDF generated successfully',
            'pdf_url' => $pdfUrl,
            'data' => $data
        ], 200);
    }
    // *********************************************************************************************
    public function dprHistoryEdit(Request $request)
    {
        log_daily(
            'DPR',
            'DPR History Edit request received with data.',
            'history_edit',
            'info',
            json_encode($request->all())
        );
        $authCompany = Auth::guard('company-api')->user();

        // dd($authCompany);
        $type = $request->type;
        $dprId = $request->dprId;
        //  $id = uuidtoid($request->uuid, $table);
        switch ($type) {
            case 'activites':
                $data = Activities::with('activitiesHistory')->where('company_id', $authCompany->company_id)
                    ->whereHas('activitiesHistory', function ($qq) use ($dprId, $authCompany) {
                        $qq->where('dpr_id', $dprId)->where('company_id', $authCompany->company_id);
                    })
                    ->get();
                $message = 'Activites Fetch Data';
                break;
            case 'material':
                $data = Materials::with('materialsHistory')->where('company_id', $authCompany->company_id)
                    ->whereHas('materialsHistory', function ($qq) use ($dprId, $authCompany) {
                        $qq->where('dpr_id', $dprId)->where('company_id', $authCompany->company_id);
                    })->get();
                $message = 'Materials Status updated';
                break;
            case 'labour':
                $data = Labour::with('labourHistory')->where('company_id', $authCompany->company_id)
                    ->whereHas('labourHistory', function ($qq) use ($dprId, $authCompany) {
                        $qq->where('dpr_id', $dprId)->where('company_id', $authCompany->company_id);
                    })->get();
                $message = 'Labour Status updated';
                break;
            case 'assets':
                $data = Assets::with('assetsHistory')->where('company_id', $authCompany->company_id)
                    ->whereHas('assetsHistory', function ($qq) use ($dprId, $authCompany) {
                        $qq->where('dpr_id', $dprId)->where('company_id', $authCompany->company_id);
                    })->get();
                $message = 'Assets Status updated';
                break;
            case 'safety':
                $data = Safety::where('dpr_id', $dprId)->where('company_id', $authCompany->company_id)->get();

                $message = 'Safety Status updated';
                break;
            case 'hinderances':
                $data = Hinderance::where('dpr_id', $dprId)->where('company_id', $authCompany->company_id)->get();
                $message = 'Hinderance Status updated';
                break;
            default:
                return $this->responseJson(false, 200, 'Something Wrong Happened');
        }
        if ($data) {
            return $this->responseJson(true, 200, $message, $data);
        } else {
            return $this->responseJson(false, 200, 'Something Wrong Happened');
        }
    }
    // *********************************************************************************************
    // generatebluckPDF
    public function generatebluckPDF($dprId)
    {
        // Retrieve DPR ID from request
        $dprId = $dprId;

        // Retrieve authenticated company user
        $authCompany = Auth::guard('company-api')->user();

        // Set page title (not clear what this method does; assuming it sets some kind of title)
        $this->setPageTitle('User Management');

        // Retrieve DPR data with related models
        $datas = Dpr::with('assets', 'activities', 'labour', 'material', 'historie', 'safetie')
            ->where('id', $dprId)
            ->where('company_id', $authCompany->company_id)
            ->where('user_id', $authCompany->id)
            ->get();
        // Assign project and subproject IDs to data array
        $data['project_id'] = $datas[0]->projects_id;
        $data['subproject_id'] = $datas[0]->sub_projects_id;
        $data['dpr_id'] = $datas[0]->id;

        // dd($datas);

        // Generate PDF from view
        $pdf = PDF::loadView('common.pdf.bluckdprs', compact('datas'));

        // Generate PDF content
        $pdfContent = $pdf->output();

        // Define filename with timestamp
        $filename = 'dpr_' . date('YmdHis') . '.pdf';

        // Define file path
        $filePath = storage_path('app/public/' . $filename);

        // Save PDF to storage
        $pdf->save($filePath);

        // Get base URL
        $baseUrl = URL::to('/');

        // Construct PDF URL
        $pdfUrl = $baseUrl . '/storage/' . $filename;

        // Return JSON response with success message and PDF URL
        return response()->json([
            'name' => $filename,
            'message' => 'PDF generated successfully',
            'pdf_url' => $pdfUrl,
            'data' => $data
        ], 200);
    }
    // *********************************************************************************************
    public function bulkDprAdd(Request $request)
    {
        log_daily(
            'DPR',
            'Bulk DPR Add request received with data.',
            'bulk_add',
            'info',
            json_encode($request->all())
        );
        $data = $request->all();
        $authCompany = Auth::guard('company-api')->user();

        if (!$authCompany) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        DB::beginTransaction();

        // try {
        $results = [];
        $dprId = null;
        // dd($data,$request->all());
        // ==================== 2. PROCESS DPR ====================
        if (isset($data['dpr'])) {
            $dpr = $this->createOrUpdateDpr($data, $authCompany);
            // dd($dpr);
            $dprId = $dpr->id;
            $results['dpr'] = $dpr;
        }
        // dd($data);

        // Ensure DPR exists if other records are provided
        if (
            !$dprId && (isset($data['activities']) || isset($data['materials']) ||
                isset($data['labour']) || isset($data['assets']) ||
                isset($data['safety']) || isset($data['hinderance']))
        ) {
            throw new \Exception('DPR must be created before adding other records');
        }

        // ==================== 3. PROCESS ACTIVITIES ====================
        if (!empty($data['activities'])) {
            $processActivities = $this->processActivities($data['activities'], $dprId, $authCompany);
            // dd($processActivities);
            $results['activities'] = $processActivities;
        }

        // ==================== 4. PROCESS MATERIALS ====================
        if (!empty($data['materials'])) {
            $processMaterials = $this->processMaterials($data['materials'], $dprId, $authCompany);
            // dd($processMaterials);
            $results['materials'] = $processMaterials;
        }

        // ==================== 5. PROCESS LABOUR ====================
        if (!empty($data['labour'])) {
            $processLabour = $this->processLabour($data['labour'], $dprId, $authCompany);
            // dd($processLabour);
            $results['labour'] = $processLabour;
        }

        // ==================== 6. PROCESS ASSETS ====================
        if (!empty($data['assets'])) {
            $processAssets = $this->processAssets($data['assets'], $dprId, $authCompany);
            $results['assets'] = $processAssets;
        }

        // ==================== 7. PROCESS SAFETY ====================
        if (!empty($data['safety'])) {
            $processSafety = $this->processSafety($data['safety'], $dprId, $authCompany);
            $results['safety'] = $processSafety;
        }

        // ==================== 8. PROCESS HINDERANCE ====================
        if (!empty($data['hinderance'])) {
            $processHinderance = $this->processHinderance($data['hinderance'], $dprId, $authCompany);
            $results['hinderance'] = $processHinderance;
        }
        $request = new Request(['dpr_id' => $dprId]);
        $dprPdf = $this->generatebluckPDF($dprId);
        $results['dpr_pdf'] = $dprPdf;
        DB::commit();


        // ==================== 9. SUCCESS RESPONSE ====================
        return $this->responseJson(true, 200, 'Fetch Companies List Successfullsy', $results);
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     log_daily(
        //         'DPR',
        //         'Bulk DPR Add request received with data.',
        //         'bulk_add Exception',
        //         'info',
        //         json_encode($request->all())
        //     );

        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Failed to add bulk DPR data',
        //         'error' => $e->getMessage()
        //     ], 500);
        // }
    }
    // ==================== HELPER METHODS ====================

    private function createOrUpdateDpr(array $data, $authCompany): Dpr
    {
        $dprData = $data['dpr'];
        // dd($dprData);
        $existingDpr = Dpr::where([
            'date' => Carbon::now()->format('Y-m-d'),
            'projects_id' => $dprData['projects_id'],
            'user_id' => $authCompany->id,
            'company_id' => $authCompany->company_id
        ])->when(isset($dprData['sub_projects_id']), function ($q) use ($dprData) {
            return $q->where('sub_projects_id', $dprData['sub_projects_id']);
        })->first();

        if ($existingDpr) {
            $dpr = $existingDpr;
        } else {
            $dpr = new Dpr();
            $dpr->dpr_no = $this->generateDprNumber();
            $dpr->date = Carbon::now()->format('Y-m-d');
            $dpr->company_id = $authCompany->company_id;
            $dpr->user_id = $authCompany->id;
            $dpr->projects_id = $dprData['projects_id'];
            $dpr->sub_projects_id = $dprData['sub_projects_id'] ?? null;
        }

        $dpr->name = $dprData['name'] ?? Carbon::now()->format('Y-m-d');
        $dpr->staps = $dprData['staps'] ?? null;
        $dpr->activities_id = $dprData['activities_id'] ?? null;
        $dpr->assets_id = $dprData['assets_id'] ?? null;
        $dpr->labours_id = $dprData['labours_id'] ?? null;
        $dpr->save();

        return $dpr;
    }

    private function processActivities(array $activities, int $dprId, $authCompany): array
    {
        // dd($activities);
        $processed = [];
        foreach ($activities as $activity) {
            $imgPath = $activity['activities_history_img'] ? $this->uploadBase64Image($activity['activities_history_img'], 'activities') : null;

            $activityHistory = ActivityHistory::updateOrCreate(
                [
                    'activities_id' => $activity['activities_history_activities_id'],
                    'dpr_id' => $dprId,
                    'company_id' => $authCompany->company_id,
                ],
                [
                    'qty' => $activity['activities_history_qty'],
                    'completion' => $activity['activities_history_completion'] != null ? $activity['activities_history_completion'] : 0,
                    'vendors_id' => $activity['activities_history_vendors_id'],
                    'remaining_qty' => $result['remaining_qty'] ?? 0,
                    'total_qty' => $result['total_qty'] ?? 0,
                    'remarkes' => $activity['activities_history_remarks'],
                    'img' => $imgPath,
                ]
            );
            $processed[] = $activityHistory;
        }
        // dd($processed);
        return $processed;
    }

    private function processMaterials(array $materials, int $dprId, $authCompany): array
    {

        $processed = [];
        foreach ($materials as $material) {
            $materialHistory = MaterialsHistory::updateOrCreate(
                [
                    'materials_id' => $material['materials_id'],
                    'dpr_id' => $dprId,
                    'company_id' => $authCompany->company_id,
                ],
                [
                    'qty' => $material['qty'],
                    'remarkes' => $material['remarkes'] ?? '',
                ]
            );
            $processed[] = $materialHistory;
        }
        return $processed;
    }

    private function processLabour(array $labour, int $dprId, $authCompany): array
    {
        // dd($labour);
        $processed = [];
        foreach ($labour as $labourRecord) {
            $labourHistory = LabourHistory::updateOrCreate(
                [
                    'labours_id' => $labourRecord['labours_id'],
                    'dpr_id' => $dprId,
                ],
                [
                    'qty' => $labourRecord['qty'],
                    'ot_qty' => $labourRecord['ot_qty'] ?? 0,
                    'rate_per_unit' => $labourRecord['rate_per_unit'] ?? 0,
                    'vendors_id' => $labourRecord['vendors_id'] ?? null,
                    'remarkes' => $labourRecord['remarkes'] ?? '',
                    'company_id' => $authCompany->company_id,
                ]
            );
            $processed[] = $labourHistory;
        }
        // dd($processed);
        return $processed;
    }

    private function processAssets(array $assets, int $dprId, $authCompany): array
    {
        // dd($assets);
        $processed = [];
        foreach ($assets as $asset) {
            $assetHistory = AssetsHistory::updateOrCreate(
                [
                    'assets_id' => $asset['assets_id'],
                    'dpr_id' => $dprId,
                ],
                [
                    'qty' => $asset['qty'],
                    'rate_per_unit' => $asset['rate_per_unit'] ?? 0,
                    'vendors_id' => $asset['vendors_id'] ?? null,
                    'remarkes' => $asset['remarkes'] ?? '',
                    'company_id' => $authCompany->company_id,
                ]
            );
            $processed[] = $assetHistory;
        }
        // dd($processed);
        return $processed;
    }

    private function processSafety(array $safetyRecords, int $dprId, $authCompany): array
    {
        $processed = [];
        foreach ($safetyRecords as $key => $safety) {
            // dd($safety);
            $imgPath = $safety['img'] ? $this->uploadBase64Image($safety['img'][$key], 'safety') : null;

            $safetyRecord = Safety::create([
                'name' => $safety['name'],
                'details' => $safety['details'] ?? '',
                'remarks' => $safety['remarks'] ?? null,
                'dpr_id' => $dprId,
                'company_id' => $authCompany->company_id,
                'img' => $imgPath,
            ]);
            $processed[] = $safetyRecord;
        }
        return $processed;
    }

    private function processHinderance(array $hinderanceRecords, int $dprId, $authCompany): array
    {
        // dd($hinderanceRecords);
        $processed = [];
        foreach ($hinderanceRecords as $key => $hinderance) {
            // dd($hinderance);
            $imgPath = $hinderance['img'] ? $this->uploadBase64Image($hinderance['img'][$key], 'hinderance') : null;
            $hinderanceRecord = Hinderance::create([
                'name' => $hinderance['name'],
                'details' => $hinderance['details'] ?? '',
                'remarks' => $hinderance['remarks'] ?? null,
                'dpr_id' => $dprId,
                'company_id' => $authCompany->company_id,
                'img' => $imgPath,
            ]);
            $processed[] = $hinderanceRecord;
        }
        return $processed;
    }

    private function generateDprNumber(): string
    {
        do {
            $number = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (Dpr::where('dpr_no', $number)->exists());

        return $number;
    }

    private function uploadBase64Image(?string $base64Image, string $folder = 'uploads'): ?string
    {
        if (!$base64Image)
            return null;

        // dd($base64Image);
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $data = substr($base64Image, strpos($base64Image, ',') + 1);
            $type = strtolower($type[1]);

            if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                return null;
            }

            $data = base64_decode($data);
            if ($data === false)
                return null;

            $filename = time() . '_' . Str::random(10) . '.' . $type;
            $path = "{$folder}/" . date('Y/m/d');
            $fullPath = storage_path("app/public/{$path}");

            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0777, true);
            }

            file_put_contents("{$fullPath}/{$filename}", $data);
            return "{$path}/{$filename}";
        }

        return null;
    }
    // *********************************************************************************************

}
