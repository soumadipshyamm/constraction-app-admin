<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\CompanyUser\UserResource;
use App\Models\Company\CompanyUser;
use App\Models\UserChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserChatController extends BaseController
{
    public function createChat(Request $request)
    {
        if ($request->isMethod('post')) {
            // Validate the incoming request
            $validated = $request->validate([
                'sender_id' => 'required|integer',
                'reciver_id' => 'required|integer',
                'room_id' => 'nullable|string',
            ]);

            // Fetch or create a UserChat entry
            $chat = UserChat::firstOrCreate([
                'sender_id' => $validated['sender_id'],
                'reciver_id' => $validated['reciver_id'],
                'room_id' => $validated['room_id'],
            ]);

            // Return a success response
            return $this->responseJson(true, 200, 'Room Created Successfully', $chat);
        }

        // Fetch authenticated company user
        $authCompany = Auth::guard('company-api')->user();
        if (!$authCompany) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $data = [];
        $userChats = UserChat::where('sender_id', $authCompany->id)->orWhere('reciver_id', $authCompany->id)->get();
        //dd($userChats);
        foreach ($userChats as $userChat) {
            $roomId = $userChat->room_id;

            // Fetch Firestore data
            $fetchRoom = getFirestoreData($roomId);
            // dd($fetchRoom);

            // Check if 'documents' key exists and is an array
            if (isset($fetchRoom['documents']) && is_array($fetchRoom['documents']) && count($fetchRoom['documents']) > 0) {
                $lastMessage = null;

                // Sort and get the latest message by createTime
                usort($fetchRoom['documents'], function ($a, $b) {
                    return strcmp($b['createTime'], $a['createTime']);
                });
                $lastMessage = $fetchRoom['documents'][0]; // Latest message
                // dd($lastMessage);
                // Build response data for the chat
                $send_user_id = $userChat->sender_id == $authCompany->id ? $userChat->reciver_id : $userChat->sender_id;
                $userrr = CompanyUser::find($send_user_id);
                $data[] = [
                    'room_id' => $roomId,
                    'message' => $lastMessage['fields']['text']['stringValue'] ?? '',
                    // 'sendBy' => $lastMessage['fields']['sendBy']['integerValue'] ?? null,
                    'sendTo' => $lastMessage['fields']['sendTo']['stringValue'] ?? $send_user_id,
                    'createTime' => $lastMessage['createTime'] ?? null,
                    // 'sendByDetails' => new UserResource(findUserDetails($lastMessage['fields']['sendBy']['integerValue'] ?? 0)),
                    'sendToDetails' => $userrr,
                ];
            }
        }
        return response()->json($data);
    }

    public function userList(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user();
        $data = CompanyUser::where('company_id', $authCompany->company_id)
            ->whereNotNull('company_role_id')
            ->where('id', '!=', $authCompany->id) // Exclude the authenticated user
            ->orderBy('id', 'desc')
            ->get();
        $message = $data->isNotEmpty() ? 'Fetch Teams List Successfully' : 'Teams List Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }

    public function sendPushNotification(Request $request)
    {
        // dd($request->all());
        $title = $request->title;
        $message = $request->message;
        $sendBy = $request->sendBy;
        $sendTo = $request->sendTo;

        $sendToDetails = CompanyUser::find($sendTo);
        $sendByDetails = CompanyUser::find($sendBy);
        if (!$sendToDetails) {
            return $this->responseJson(false, 400, 'User not found');
        }
        $sendToFcmToken = $sendToDetails->fcm_token;
        if (!$sendToFcmToken) {
            return $this->responseJson(false, 400, 'User FCM token not found');
        }
        $data = [
            'title' => $title,
            'body' => $message,
            'sender_name' => $sendByDetails->name ?? 'Koncite',
            'sendBy' => $sendByDetails,
            'sendTo' => $sendToDetails,
        ];

        $notificationData = (object)[
            'body' => $message,
            'title' => $title,
            'data' =>  $data,
        ];
        // dd($notificationData);
        $response = sendNotification($notificationData, $sendToFcmToken);
        return $this->responseJson(true, 200, 'Push notification sent successfully', $response);
    }


    // Update FCM token
    public function fcmUpdate(Request $request)
    {
        $validated = $request->validate([
            'fcm_token' => 'required|string',
        ]);

        $authCompany = Auth::guard('company-api')->user();
        $authCompany->fcm_token = $validated['fcm_token'];
        $authCompany->save();

        return $this->responseJson(true, 200, 'FCM token updated successfully', $authCompany);
    }
}
