<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Labours\LabourHistoryResources;
use App\Models\Company\Labour;
use App\Models\Company\LabourHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LabourHistoryController extends BaseController
{
    public function index($id)
    {
        /* The line `// dd();` is commented out, which means it is not executed. */
        // dd($id);
        $authConpany = Auth::guard('company-api')->user()->company_id;
        $data = LabourHistory::where('company_id', $authConpany)->where('dpr_id', $id)->orderBy('id', 'asc')->get();
        return $data;
    }
    public function add(Request $request)
    {
        log_daily(
            'LabourHistory',
            'Labour History Add/Update request received with data.',
            'add',
            'info',
            json_encode($request->all())
        );
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $validator = Validator::make($request->all(), [
            '*.qty' => 'required',
            // '*.activities_id' => 'required',
            // '*.vendors_id' => 'required',
            '*.rate_per_unit' => 'required',
            // '*.dpr_id' => 'required',
        ]);
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        $datas = $request->all();
        // dd($datas);
        DB::beginTransaction();
        try {

            // if ($request[0]['type'] == "previous") {
            //     $labourData = Labour::with(['units'])
            //         ->whereHas('labourHistory', function ($query) use ($request) {
            //             $query->where('dpr_id', $request[0]['type']);
            //         })->where('company_id', $authCompany)
            //         // ->whereIn('id', $getLabourId)
            //         ->get();
            //     $result =  LabourHistoryResources::collection($labourData);
            //     $message = 'Fetch Labour List Successfully';
            // } else {
                foreach ($datas as $data) {
                    $uuid = Str::uuid();
                    $qty = $data['qty'];
                    $ot_qty = $data['ot_qty'];
                    $labours_id = $data['labours_id'];
                    $activities_id = $data['activities_id'] ?? null;
                    $vendors_id = $data['vendors_id'] ?? null;
                    $rate_per_unit = $data['rate_per_unit'];
                    $dpr_id = $data['dpr_id'];
                    $remarkes = $data['remarkes'];
                    $company_id = $authCompany;

                    $updateData = compact(
                        'qty',
                        'ot_qty',
                        'activities_id',
                        'vendors_id',
                        'rate_per_unit',
                        'remarkes',
                        'company_id',
                    );
                    $criteria = compact('labours_id', 'dpr_id');
                    // Update or create the record
                    $result = LabourHistory::updateOrCreate($criteria, $updateData);
                }
                $message = 'Labours Details Updated Successfullsy';
            // }

            DB::commit();
            return $this->responseJson(true, 200, $message, $result);
            // return $this->responseJson(true, 201, $message, $isLabourCreated ?? $isLabourUpdate);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    // public function edit(Request $request)
    // {
    //     $getLabourId = $request->get('getLabour');
    //     $dprId = $request->input('dprId');
    //     $authCompany = Auth::guard('company-api')->user();
    //     $labours = [];
    //     foreach ($getLabourId as $labourId) {
    //         $laboursHistory = LabourHistory::where('labours_id', $labourId)
    //             ->where('dpr_id', $dprId)
    //             ->where('company_id', $authCompany->company_id)
    //             ->first();

    //         if ($laboursHistory) {
    //             $labour = Labour::where('id', $labourId)
    //                 ->where('company_id', $authCompany->company_id)
    //                 ->first();

    //             if ($labour) {
    //                 $labours[] = new LabourHistoryResources([
    //                     'labour' => $labour,
    //                     'labour_history' => $laboursHistory
    //                 ]);
    //             }
    //         } else {
    //             $labour = Labour::where('id', $labourId)
    //                 ->where('company_id', $authCompany->company_id)
    //                 ->first();

    //             if ($labour) {
    //                 $labours[] = new LabourHistoryResources([
    //                     'labour' => $labour
    //                 ]);
    //             }
    //         }
    //     }
    //     $message = 'Fetch Labour List Successfully';
    //     return response()->json(['success' => true, 'status' => 200, 'message' => $message, 'data' => $labours]);
    // }

    public function edit(Request $request)
    {
        $getLabourId = $request->getLabour;
        $dprId = $request->dprId;
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $labourData = Labour::with(['units', 'labourHistory' => function ($query) use ($dprId) {
            $query->where('dpr_id', $dprId);
        }])->where('company_id', $authCompany)
            ->whereIn('id', $getLabourId)
            ->get();
        $labours =  LabourHistoryResources::collection($labourData);
        $message = 'Fetch Labour List Successfully';
        return response()->json(['success' => true, 'status' => 200, 'message' => $message, 'data' => $labours]);
    }


    function flattenNestedData($data, &$result = [])
    {
        foreach ($data as $item) {
            if (is_array($item)) {
                $this->flattenNestedData($item, $result);
            } else {
                $result[] = $item;
            }
        }
        return $result;
    }
}
