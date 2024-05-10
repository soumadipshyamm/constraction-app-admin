<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Models\Company\Company_role;

class RoleController extends BaseController
{
    public function roleList(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Company_role::where('company_id', $authCompany)->get();
        // dd($data->toArray());
        $message = $data->isNotEmpty() ? 'Fetch Role List Successfully' : 'Role List Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }
    public function add(Request $request)
    {
    }
    public function edit(Request $request)
    {
    }
    public function search(Request $request)
    {
    }
    public function delete(Request $request)
    {
    }
}
