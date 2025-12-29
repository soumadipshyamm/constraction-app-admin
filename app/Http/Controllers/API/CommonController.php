<?php

namespace App\Http\Controllers\API;

use App\Models\Cities;
use App\Models\States;
use App\Models\Countries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company\CompanyUser;

class CommonController extends Controller
{
    public function getCountry()
    {
        $country = Countries::select('id', 'name', 'phonecode', 'slug')->where('status', 1)->get();
        return $country;
    }
    public function getStates(Request $request)
    {
        $states = States::select('id', 'name')->where('country_id', $request->countryId)->where('status', 1)->get();
        return $states;
    }
    public function getCities(Request $request)
    {
        $cities = Cities::select('id', 'name')->where('state_id', $request->statesId)->where('status', 1)->get();
        return $cities;
    }
    public function getStatesByCountry(Request $request)
    {
        $states = States::select('id', 'name')->where('country_id', $request->countryId)->where('status',1)->get();
        return $states;
    }

    public function projectToStoreList(Request $request)
    {
        dd($request->all());
    }
    public function getChatsData(Request $request)
    {
        // dd(getFirestoreData());
    }

    public function driverDeleteAccount(Request $request)
    {
        if ($request->isMethod('post')) {
            $user = CompanyUser::where('email', $request->input('email'))->first();
            // dd($user);
            if ($user) {
                // Perform the delete account logic here
                // $user->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Account deleted successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Number does not exist'
                ], 404);
            }
        }
        return view('deleteAccount.driver-delete-ac');
    }

    public function privacyPolicy()
    {
        return view('Frontend.privacy-policy.privacy_policy');
    }
}
