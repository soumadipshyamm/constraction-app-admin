<?php

namespace App\Http\Controllers;

use App\Http\Resources\API\Notifaction\NotifactionResource;
use App\Models\Notifaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifactionController extends BaseController
{
    public function testNotifaction(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;

        $token = $request->fcm_token;
        $notificationData = (object)[
            'body' => 'New Booking Have Arrived',
            'title' => __('Booking Created'),
            'data' =>  "BookingResource()",
            'image' => 'https://example.com/path/to/image.jpg',
        ];

        $response = sendNotification($notificationData, $token);
        // $data = sendNotification($token, $request->title, $body, $notifaction = 'test');
        return $response;
    }

    public function fetchNotifaction()
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $userId = auth()->user()->id;
        $data = Notifaction::where('user_id', $userId)->where('company_id', $authCompany)->orderBy('created_at', 'desc')->get();
        $result = $data ? NotifactionResource::collection($data) : [];
        return $this->responseJson(true, 200, 'User Notifaction List Found Successfully', $result);
    }
    // *****************************************************************************************************************
    public function viewNotifactionUpdate(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Notifaction::where('id', $request->id)->update([
            'status' => 1
        ]);
        return $this->responseJson(true, 200, 'User Notifaction Update Successfully', []);
    }
    // *****************************************************************************************************************
    public function viewAllNotifaction(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $userId = auth()->user()->id;
        $data = Notifaction::where('user_id', $userId)->where('company_id', $authCompany)->where('status', 0)->orderBy('created_at', 'desc')
            // ->get();
            // dd($data->toArray());
            ->update([
                'status' => 2
            ]);
        return $this->responseJson(true, 200, 'User Notifaction Update Successfully', []);
    }
}
