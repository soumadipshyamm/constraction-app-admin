<?php

namespace App\Http\Controllers\API;

use App\Models\Cities;
use App\Models\States;
use App\Models\Countries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    public function getCountry()
    {
        $country = Countries::select('id', 'name')->get();
        return $country;
    }
    public function getStates(Request $request)
    {
        $states = States::select('id', 'name')->where('country_id', $request->countryId)->get();
        return $states;
    }
    public function getCities(Request $request)
    {
        $cities = Cities::select('id', 'name')->where('state_id', $request->statesId)->get();
        return $cities;
    }

    public function projectToStoreList(Request $request)
    {
        dd($request->all());
    }
}
