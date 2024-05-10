<?php

namespace App\Http\Controllers\API;

use App\Models\API\Dpr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Resources\ActivitesResource;
use App\Http\Resources\API\Activities\DprActivitesResources;
use App\Http\Resources\API\Assets\AssetsHistoryResources;
use App\Http\Resources\API\DPR\DprLabourResources;
use App\Http\Resources\API\DPR\DprMaterialsResources;
use App\Http\Resources\API\DPR\DprResources;
use App\Http\Resources\API\Labours\LabourHistoryResources;
use App\Http\Resources\DPR\DprAssetsResources;
use App\Models\Company\ActivityHistory;
use App\Models\Company\AssetsHistory;
use App\Models\Company\LabourHistory;
use App\Models\Company\MaterialsHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class DprController extends BaseController
{
    public function index(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user();
        $this->setPageTitle('User Management');
        $datas = Dpr::with('assets', 'activities', 'labour', 'material', 'historie', 'safetie')->where('company_id', $authCompany->company_id)->where('user_id', $authCompany->id)->get();
        if (count($datas) > 0) {
            return $this->responseJson(true, 200, 'Fetch DPR List Successfullsy', $datas);
        } else {
            return $this->responseJson(true, 200, 'DPR List Data Not Found', []);
        }
    }
    public function add(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user();

        DB::beginTransaction();
        $checkDpr = Dpr::where(['date' => Carbon::now()->format('Y-m-d'), 'projects_id' => $request->projects_id, 'user_id' => $authCompany->id])->where('sub_projects_id', $request->sub_projects_id)->first();
        try {
            // dd($checkDpr);
            if ($request->id == null && $checkDpr == null) {
                $isDprDatas = new Dpr();
                $isDprDatas->name = $request->name;
                $isDprDatas->date = Carbon::now()->format('Y-m-d');
                $isDprDatas->company_id = $authCompany->company_id;
                $isDprDatas->user_id = $authCompany->id;
                $isDprDatas->projects_id = $request->projects_id;
                $isDprDatas->sub_projects_id = $request->sub_projects_id;
            } else {
                $isDprDatas = Dpr::find($checkDpr->id);
            }
            $isDprDatas->projects_id = $request->projects_id;
            $isDprDatas->sub_projects_id = $request->sub_projects_id;
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
            if (isset($isDprDatas)) {
                DB::commit();
                return $this->responseJson(true, 201, $message, $isDprDatas);
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
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Dpr::where('id', $uuid)
            ->where('company_id', $authCompany)
            ->delete();
        $message = $data > 0 ? 'DPR Delete Successfully' : 'DPR Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }
    public function dprCheck(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user();
        $datas = Dpr::where('staps', '!=', 7)
            ->where('company_id', $authCompany->company_id)
            ->where('user_id', $authCompany->id)
            ->whereNotNull('projects_id')
            ->orderBy('id', 'desc')
            ->get();
            // dd($datas);
        $message =  'Fetch DPR List Successfully';
        return $this->responseJson(true, 200, $message, DprResources::collection($datas));
    }

    // **************************PDF*******************************************************************/
    // public function generatePDF(Request $request)
    // {
    //     // dd($request->dpr);
    //     $dprId = $request->dpr;
    //     $authCompany = Auth::guard('company-api')->user();
    //     $this->setPageTitle('User Management');
    //     $datas = Dpr::with('assets', 'activities', 'labour', 'material', 'historie', 'safetie')
    //         ->where('id', $dprId)
    //         ->where('company_id', $authCompany->company_id)
    //         ->where('user_id', $authCompany->id)
    //         ->get();
    //     // Load the view and pass the data
    //     $pdf = Pdf::loadView('common.pdf.dpr', compact('datas'));
    //     // Return the PDF as a downloadable file
    //     $pdfContent = $pdf->output();
    //     // return response($pdfContent, 200)
    //     //     ->header('Content-Type', 'application/pdf')
    //     //     ->header('Content-Disposition', 'attachment; filename="sample.pdf"');
    //     // return response()->streamDownload(function () use ($pdfContent) {
    //     //     echo $pdfContent;
    //     // }, 'sample.pdf');
    //     // Download
    //     $filename = 'dpr_' . date('YmdHis') . '.pdf';
    //     // Define the file location
    //     $filePath = storage_path('app/' . $filename);
    //     // Save the PDF to the specified location
    //     $pdf->save($filePath);
    //     // Return a response with a link to download the PDF
    //     return response()->json([
    //         'message' => 'PDF generated successfully',
    //         'pdf_url' => $filePath // Provide the URL to the saved PDF
    //     ], 200);
    // }
    // *********************************************************************************************

    public function generatePDF(Request $request)
    {
        // dd($request->dpr);
        // generatePDF
        // $validator = Validator::make($request->all(), [
        //     'generatePDF' => 'required',
        //     // 'projects_id' => 'required',
        //     // 'sub_projects_id' => 'sometimes'
        // ]);
        // if ($validator->fails()) {
        //     $status = false;
        //     $code = 422;
        //     $response = [];
        //     $message = $validator->errors()->first();
        //     return $this->responseJson($status, $code, $message, $response);
        // }
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

        // Generate PDF from view
        $pdf = PDF::loadView('common.pdf.dpr', compact('datas'));

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
        // $cleanedUrl = str_replace('"', "'",  $pdfUrl);
        // Return JSON response with success message and PDF URL
        return response()->json([
            'name' => $filename,
            'message' => 'PDF generated successfully',
            'pdf_url' =>  $pdfUrl // Provide the URL to the saved PDF
        ], 200);
    }
    // *********************************************************************************************
    // public function dprHistoryUpdate(Request $request)
    // {
    //     // dd($request);
    //     if ($request->ajax()) {
    //         $type = $request->type;
    //         $data = $request->dprId;
    //         //  $id = uuidtoid($request->uuid, $table);
    //         switch ($type) {
    //             case 1:
    //                 // $data = User::where('id', $id)->update(['is_active' => $request->is_active]);
    //                 $message = 'Users Status updated';
    //                 break;
    //             case 2:
    //                 // $data = User::where('id', $id)->update(['is_active' => $request->is_active]);
    //                 $message = 'Users Status updated';
    //                 break;
    //             default:
    //                 return $this->responseJson(false, 200, 'Something Wrong Happened');
    //         }
    //         if ($data) {
    //             return $this->responseJson(true, 200, $message, $data);
    //         } else {
    //             return $this->responseJson(false, 200, 'Something Wrong Happened');
    //         }
    //     }
    //     abort(405);
    // }
}
